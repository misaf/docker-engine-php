<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Transport;

use Misaf\DockerEngine\Contracts\CancellableStream;
use Misaf\DockerEngine\Exceptions\TimeoutException;
use Misaf\DockerEngine\Exceptions\TransportException;
use Symfony\Contracts\HttpClient\Exception\TimeoutExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

final class SymfonyResponseStream implements CancellableStream
{
    private string $buffer = '';

    private bool $started = false;

    private bool $finished = false;

    public function __construct(
        private readonly ResponseInterface $response,
        private readonly ResponseStreamInterface $chunks,
        private readonly string $endpoint,
    ) {}

    public function read(int $length = 8192): string
    {
        $length = max(1, $length);

        try {
            while (mb_strlen($this->buffer, '8bit') < $length && ! $this->finished) {
                if ( ! $this->started) {
                    $this->chunks->rewind();
                    $this->started = true;
                }

                if ( ! $this->chunks->valid()) {
                    $this->finished = true;

                    break;
                }

                $chunk = $this->chunks->current();
                $this->chunks->next();

                if ($chunk->isTimeout()) {
                    throw new TimeoutException(sprintf('Docker stream from %s exceeded its idle timeout.', $this->endpoint));
                }

                $this->buffer .= $chunk->getContent();

                if ($chunk->isLast()) {
                    $this->finished = true;
                }
            }
        } catch (TimeoutExceptionInterface $exception) {
            throw new TimeoutException(sprintf('Docker stream from %s timed out: %s', $this->endpoint, $exception->getMessage()), previous: $exception);
        } catch (TransportExceptionInterface $exception) {
            throw TransportException::connection($this->endpoint, $exception->getMessage(), $exception);
        }

        $value = mb_substr($this->buffer, 0, $length, '8bit');
        $this->buffer = mb_substr($this->buffer, mb_strlen($value, '8bit'), null, '8bit');

        return $value;
    }

    public function write(string $data): int
    {
        throw new TransportException('Symfony HttpClient response streams are read-only; Docker upgraded connections use the specialized socket adapter.');
    }

    public function eof(): bool
    {
        return $this->finished && '' === $this->buffer;
    }

    public function close(): void
    {
        $this->finished = true;
        $this->buffer = '';
        $this->response->cancel();
    }

    public function cancel(): void
    {
        $this->close();
    }
}
