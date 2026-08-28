<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Transport\Socket;

use Misaf\DockerEngine\Contracts\Stream\Stream;
use Misaf\DockerEngine\Exceptions\TransportException;

final class ResourceStream implements Stream
{
    /** @param resource $resource */
    public function __construct(private $resource) {}

    public static function memory(string $contents = ''): self
    {
        $resource = fopen('php://temp', 'w+b');

        if (false === $resource) {
            throw TransportException::connection('php://temp', 'unable to open temporary stream');
        }

        fwrite($resource, $contents);
        rewind($resource);

        return new self($resource);
    }

    public function read(int $length = 8192): string
    {
        $value = fread($this->resource, max(1, $length));

        if (false === $value) {
            throw TransportException::connection('stream', 'read failed');
        }

        return $value;
    }

    public function write(string $data): int
    {
        $written = fwrite($this->resource, $data);

        if (false === $written) {
            throw TransportException::connection('stream', 'write failed');
        }

        return $written;
    }

    public function eof(): bool
    {
        return feof($this->resource);
    }

    public function close(): void
    {
        if (is_resource($this->resource)) {
            fclose($this->resource);
        }
    }

    public function rewind(): void
    {
        rewind($this->resource);
    }
}
