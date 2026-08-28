<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Tests\Support;

use Misaf\DockerEngine\Contracts\Stream\CancellableStream;
use Misaf\DockerEngine\Contracts\Stream\HalfClosableStream;

final class FragmentedStream implements CancellableStream, HalfClosableStream
{
    /** @var list<string> */
    private array $fragments;

    public string $written = '';

    public bool $cancelled = false;

    public bool $writeClosed = false;

    /** @param list<string> $fragments */
    public function __construct(array $fragments)
    {
        $this->fragments = $fragments;
    }

    public function read(int $length = 8192): string
    {
        $fragment = array_shift($this->fragments) ?? '';
        $chunk = mb_substr($fragment, 0, max(1, $length), '8bit');
        $remaining = mb_substr($fragment, mb_strlen($chunk, '8bit'), null, '8bit');

        if ('' !== $remaining) {
            array_unshift($this->fragments, $remaining);
        }

        return $chunk;
    }

    public function write(string $data): int
    {
        $this->written .= $data;

        return mb_strlen($data, '8bit');
    }

    public function eof(): bool
    {
        return [] === $this->fragments || $this->cancelled;
    }

    public function close(): void
    {
        $this->cancel();
    }

    public function cancel(): void
    {
        $this->cancelled = true;
    }

    public function closeWrite(): void
    {
        $this->writeClosed = true;
    }
}
