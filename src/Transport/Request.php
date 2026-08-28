<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Transport;

use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\Contracts\Stream\Stream;

final readonly class Request
{
    /**
     * @param array<string, scalar|list<scalar>|null> $query
     * @param array<string, string> $headers
     */
    public function __construct(
        public string $method,
        public string $path,
        public ?ApiVersion $version = null,
        public array $query = [],
        public array $headers = [],
        /** @var array<array-key, mixed>|string|object|Stream|null */
        public string|object|array|null $body = null,
        public ?float $timeout = null,
        public ?float $streamIdleTimeout = null,
    ) {}

    public function target(): string
    {
        $path = '/' . mb_ltrim($this->path, '/');
        $target = (null === $this->version ? '' : $this->version->pathPrefix()) . $path;
        $query = self::buildQuery($this->query);

        return '' === $query ? $target : $target . '?' . $query;
    }

    /** @param array<string, scalar|list<scalar>|null> $query */
    private static function buildQuery(array $query): string
    {
        $pairs = [];

        foreach ($query as $name => $value) {
            if (null === $value) {
                continue;
            }

            foreach (is_array($value) ? $value : [$value] as $item) {
                $normalized = is_bool($item) ? ($item ? 'true' : 'false') : (string) $item;
                $pairs[] = rawurlencode($name) . '=' . rawurlencode($normalized);
            }
        }

        return implode('&', $pairs);
    }
}
