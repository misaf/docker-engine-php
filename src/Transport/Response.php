<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Transport;

use JsonException;
use Misaf\DockerEngine\Exceptions\InvalidResponseException;

final readonly class Response
{
    /** @param array<string, list<string>> $headers */
    public function __construct(
        public int $statusCode,
        public array $headers,
        public string $body,
    ) {}

    public function successful(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    public function failed(): bool
    {
        return ! $this->successful();
    }

    public function status(): int
    {
        return $this->statusCode;
    }

    public function body(): string
    {
        return $this->body;
    }

    /** @return ($key is null ? array<array-key, mixed> : mixed) */
    public function json(?string $key = null): mixed
    {
        try {
            $data = json_decode($this->body, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new InvalidResponseException('Docker returned invalid JSON: ' . $exception->getMessage(), previous: $exception);
        }

        if ( ! is_array($data)) {
            throw new InvalidResponseException('Docker returned a JSON value where an object or array was required.');
        }

        return null === $key ? $data : ($data[$key] ?? null);
    }

    public function header(string $name): ?string
    {
        foreach ($this->headers as $header => $values) {
            if (0 === strcasecmp($header, $name)) {
                return $values[0] ?? null;
            }
        }

        return null;
    }
}
