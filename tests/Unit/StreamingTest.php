<?php

declare(strict_types=1);

use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Misaf\DockerEngine\Streaming\DockerStreamDecoder;
use Misaf\DockerEngine\Streaming\ProgressStream;
use Misaf\DockerEngine\Streaming\StreamType;
use Misaf\DockerEngine\Transport\ResourceStream;
use Misaf\DockerEngine\Transport\WebSocketStream;

it('keeps multiplexed stdout and stderr logically separate', function (): void {
    $stream = ResourceStream::memory(dockerFrame(1, 'out') . dockerFrame(2, 'err'));
    $frames = iterator_to_array((new DockerStreamDecoder())->decode($stream));

    expect($frames)->toHaveCount(2)
        ->and($frames[0]->type)->toBe(StreamType::Stdout)
        ->and($frames[0]->payload)->toBe('out')
        ->and($frames[1]->type)->toBe(StreamType::Stderr)
        ->and($frames[1]->payload)->toBe('err');
});

it('rejects incomplete multiplexed frames', function (): void {
    $stream = ResourceStream::memory(chr(1) . "\0\0\0" . pack('N', 10) . 'short');

    expect(fn(): array => iterator_to_array((new DockerStreamDecoder())->decode($stream)))
        ->toThrow(InvalidResponseException::class);
});

it('parses line-delimited progress and preserves stream errors', function (): void {
    $events = iterator_to_array(new ProgressStream(ResourceStream::memory(
        "{\"status\":\"Pulling\",\"id\":\"layer\"}\n{\"error\":\"denied\",\"errorDetail\":{\"message\":\"denied\"}}\n",
    )));

    expect($events)->toHaveCount(2)
        ->and($events[0]->status)->toBe('Pulling')
        ->and($events[1]->error)->toBe('denied')
        ->and($events[1]->errorDetail)->toBe(['message' => 'denied']);
});

it('decodes websocket frames used by container attach', function (): void {
    $stream = new WebSocketStream(ResourceStream::memory(
        chr(0x82) . chr(5) . 'hello' . chr(0x88) . chr(0),
    ));

    expect($stream->read(2))->toBe('he')
        ->and($stream->read())->toBe('llo')
        ->and($stream->read())->toBe('')
        ->and($stream->eof())->toBeTrue();
});
