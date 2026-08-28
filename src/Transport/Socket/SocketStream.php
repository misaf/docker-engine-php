<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Transport\Socket;

use Misaf\DockerEngine\Contracts\Stream\CancellableStream;
use Misaf\DockerEngine\Contracts\Stream\HalfClosableStream;
use Misaf\DockerEngine\Exceptions\TransportException;

final class SocketStream implements CancellableStream, HalfClosableStream
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

    public function closeWrite(): void
    {
        if (is_resource($this->socket) && ! stream_socket_shutdown($this->socket, STREAM_SHUT_WR)) {
            throw TransportException::connection('docker stream', 'socket half-close failed');
        }
    }

    public function cancel(): void
    {
        $this->close();
    }
}
