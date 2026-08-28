<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Streaming;

use Generator;
use IteratorAggregate;
use JsonException;
use Misaf\DockerEngine\Contracts\Stream;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;
use Traversable;

/** @implements IteratorAggregate<int, ProgressEvent> */
final readonly class ProgressStream implements IteratorAggregate
{
    public function __construct(private Stream $stream) {}

    /** @return Traversable<int, ProgressEvent> */
    public function getIterator(): Traversable
    {
        yield from $this->events();
    }

    /** @return Generator<int, ProgressEvent> */
    private function events(): Generator
    {
        $buffer = '';

        while (! $this->stream->eof()) {
            $buffer .= $this->stream->read();

            while (false !== ($newline = mb_strpos($buffer, "\n"))) {
                $line = mb_trim(mb_substr($buffer, 0, $newline));
                $buffer = mb_substr($buffer, $newline + 1);

                if ('' !== $line) {
                    yield $this->event($line);
                }
            }
        }

        if ('' !== mb_trim($buffer)) {
            yield $this->event(mb_trim($buffer));
        }
    }

    private function event(string $line): ProgressEvent
    {
        try {
            $data = json_decode($line, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new InvalidResponseException('Docker progress stream contains invalid JSON: ' . $exception->getMessage(), previous: $exception);
        }

        if (! is_array($data)) {
            throw new InvalidResponseException('Docker progress event must be a JSON object.');
        }

        return new ProgressEvent(
            status: is_string($data['status'] ?? null) ? $data['status'] : null,
            id: is_string($data['id'] ?? null) ? $data['id'] : null,
            progress: is_string($data['progress'] ?? null) ? $data['progress'] : null,
            progressDetail: is_array($data['progressDetail'] ?? null) ? $data['progressDetail'] : null,
            error: is_string($data['error'] ?? null) ? $data['error'] : null,
            errorDetail: is_array($data['errorDetail'] ?? null) ? $data['errorDetail'] : null,
            aux: is_array($data['aux'] ?? null) ? $data['aux'] : null,
        );
    }
}
