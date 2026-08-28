<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Transport;

use Misaf\DockerEngine\Contracts\Stream;
use Misaf\DockerEngine\Exceptions\TransportException;

final class SocketStream implements Stream
{
    /** @param resource $socket */
    public function __construct(private $socket) {}

    public function read(int $length = 8192): string
    {
        $value = fread($this->socket, max(1, $length));

        if (false === $value) {
            throw TransportException::connection('docker stream', 'socket read failed');
        }

        return $value;
    }

    public function write(string $data): int
    {
        $written = fwrite($this->socket, $data);

        if (false === $written) {
            throw TransportException::connection('docker stream', 'socket write failed');
        }

        return $written;
    }

    public function eof(): bool
    {
        return feof($this->socket);
    }

    public function close(): void
    {
        if (is_resource($this->socket)) {
            fclose($this->socket);
        }
    }
}
