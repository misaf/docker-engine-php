<?php

declare(strict_types=1);

use Misaf\DockerEngine\Contracts\Stream;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Exceptions\TimeoutException;
use Misaf\DockerEngine\Exec\ExecSession;
use Misaf\DockerEngine\Streaming\DockerStreamDecoder;
use Misaf\DockerEngine\Streaming\StreamType;
use Misaf\DockerEngine\Tests\Support\FragmentedStream;
use Misaf\DockerEngine\ValueObjects\ExecId;

it('decodes headers and payloads split across arbitrary reads', function (): void {
    $encoded = dockerFrame(1, 'stdout') . dockerFrame(2, 'stderr');
    $fragments = mb_str_split($encoded, 1);
    $frames = iterator_to_array((new DockerStreamDecoder())->decode(new FragmentedStream($fragments)));

    expect($frames)->toHaveCount(2)
        ->and($frames[0]->payload)->toBe('stdout')
        ->and($frames[1]->payload)->toBe('stderr');
});

it('decodes several interleaved frames from a single read', function (): void {
    $stream = new FragmentedStream([
        dockerFrame(1, 'one') . dockerFrame(2, 'two') . dockerFrame(1, 'three'),
    ]);
    $frames = iterator_to_array((new DockerStreamDecoder())->decode($stream));

    expect(array_map(static fn($frame): StreamType => $frame->type, $frames))
        ->toBe([StreamType::Stdout, StreamType::Stderr, StreamType::Stdout])
        ->and(array_map(static fn($frame): string => $frame->payload, $frames))
        ->toBe(['one', 'two', 'three']);
});

it('preserves binary and empty multiplex payloads', function (): void {
    $binary = "\x00\xff\xfe\x80payload";
    $frames = iterator_to_array((new DockerStreamDecoder())->decode(new FragmentedStream([
        dockerFrame(1, $binary) . dockerFrame(2, ''),
    ])));

    expect($frames[0]->payload)->toBe($binary)
        ->and($frames[1]->payload)->toBe('');
});

it('rejects malformed identifiers, reserved bytes, and truncated frames', function (string $stream): void {
    expect(fn(): array => iterator_to_array((new DockerStreamDecoder())->decode(new FragmentedStream([$stream]))))
        ->toThrow(InvalidResponseException::class);
})->with([
    'unknown stream identifier'  => chr(9) . "\0\0\0" . pack('N', 0),
    'nonzero reserved byte'      => chr(1) . "\0\1\0" . pack('N', 0),
    'truncated header'           => chr(1) . "\0\0",
    'daemon closes in payload'   => chr(1) . "\0\0\0" . pack('N', 5) . 'no',
]);

it('handles long-running fragmented streams without losing frame boundaries', function (): void {
    $frames = [];

    for ($index = 0; $index < 1_000; $index++) {
        $frames[] = dockerFrame(1 + ($index % 2), (string) $index);
    }

    $decoded = iterator_to_array((new DockerStreamDecoder())->decode(new FragmentedStream(mb_str_split(implode('', $frames), 7))));

    expect($decoded)->toHaveCount(1_000)
        ->and($decoded[999]->payload)->toBe('999');
});

it('propagates stream idle timeouts', function (): void {
    $stream = new class implements Stream {
        public function read(int $length = 8192): string
        {
            throw new TimeoutException('idle timeout');
        }

        public function write(string $data): int
        {
            return 0;
        }

        public function eof(): bool
        {
            return false;
        }

        public function close(): void {}
    };

    expect(fn(): array => iterator_to_array((new DockerStreamDecoder())->decode($stream)))
        ->toThrow(TimeoutException::class, 'idle timeout');
});

it('supports stdin forwarding, half-close, cancellation, and TTY raw streams', function (): void {
    $raw = new FragmentedStream(["terminal\r\n"]);
    $session = new ExecSession(new ExecId('exec'), $raw, true);
    $stdout = '';

    expect($session->write("input\n"))->toBe(6);
    $session->closeStdin();
    $session->consume(static function (string $chunk) use (&$stdout): void {
        $stdout .= $chunk;
    });
    $session->cancel();

    expect($raw->written)->toBe("input\n")
        ->and($raw->writeClosed)->toBeTrue()
        ->and($raw->cancelled)->toBeTrue()
        ->and($stdout)->toBe("terminal\r\n");
});
