<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Tools\OpenApi;

use Misaf\DockerEngine\ApiVersion;
use RuntimeException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

final readonly class OpenApiSpecRepository
{
    public function __construct(private string $directory) {}

    /** @return list<string> */
    public function versions(): array
    {
        if ( ! is_dir($this->directory)) {
            throw new RuntimeException('Specification directory does not exist: ' . $this->directory);
        }

        $versions = [];
        $finder = Finder::create()->files()->in($this->directory)->depth(0)->name('/^v1\.(?:4\d|5[0-5])\.yaml$/')->sortByName();

        foreach ($finder as $file) {
            $versions[] = mb_substr($file->getBasename('.yaml'), 1);
        }

        return $versions;
    }

    public function file(string|ApiVersion $version): string
    {
        $version = $version instanceof ApiVersion ? $version : ApiVersion::parse($version);
        $file = $this->directory . '/v' . $version->value . '.yaml';

        if ( ! is_file($file)) {
            throw new RuntimeException('Missing specification ' . $file);
        }

        return $file;
    }

    /** @return array<string, mixed> */
    public function parse(string|ApiVersion $version): array
    {
        $file = $this->file($version);

        try {
            $spec = Yaml::parseFile($file);
        } catch (ParseException $exception) {
            throw new RuntimeException('Invalid OpenAPI YAML in ' . $file . ': ' . $exception->getMessage(), previous: $exception);
        }

        if ( ! is_array($spec) || ! is_array($spec['paths'] ?? null) || ! is_array($spec['definitions'] ?? null)) {
            throw new RuntimeException($file . ' is not a supported Docker Swagger document.');
        }

        return $spec;
    }

    /** @return list<string> */
    public function unresolvedReferences(array $spec): array
    {
        $unresolved = [];
        $this->walkReferences($spec, $spec, $unresolved);

        return array_values(array_unique($unresolved));
    }

    /** @param array<array-key, mixed> $value @param array<array-key, mixed> $document @param list<string> $unresolved */
    private function walkReferences(array $value, array $document, array &$unresolved): void
    {
        foreach ($value as $key => $item) {
            if ('$ref' === $key && is_string($item) && str_starts_with($item, '#/')) {
                $resolved = $document;

                foreach (explode('/', mb_substr($item, 2)) as $segment) {
                    $segment = str_replace(['~1', '~0'], ['/', '~'], rawurldecode($segment));

                    if ( ! is_array($resolved) || ! array_key_exists($segment, $resolved)) {
                        $unresolved[] = $item;

                        continue 2;
                    }

                    $resolved = $resolved[$segment];
                }
            }

            if (is_array($item)) {
                $this->walkReferences($item, $document, $unresolved);
            }
        }
    }
}
