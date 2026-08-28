<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Tools\OpenApi;

final readonly class ApiCoverageValidator
{
    public function __construct(
        private OpenApiSpecRepository $specs,
        private string $apiDirectory,
    ) {}

    /** @return array{rows: list<array{string, int, int, string, int, int}>, errors: list<string>} */
    public function validate(): array
    {
        $rows = [];
        $errors = [];

        foreach ($this->specs->versions() as $version) {
            $spec = $this->specs->parse($version);
            $suffix = 'V' . str_replace('.', '_', $version);
            [$operations, $tags] = $this->operations($spec);
            $definitions = $spec['definitions'];
            $manifestClass = 'Misaf\DockerEngine\\Api\\' . $suffix . '\\Manifest';

            if ( ! class_exists($manifestClass)) {
                $errors[] = 'Missing generated manifest ' . $manifestClass;

                continue;
            }

            /** @var array<string, array{tag: string, method: string, path: string}> $manifest */
            $manifest = $manifestClass::OPERATIONS;
            /** @var array<string, string> $schemas */
            $schemas = $manifestClass::SCHEMAS;
            /** @var list<string> $manifestTags */
            $manifestTags = $manifestClass::TAGS;
            $implemented = 0;

            foreach ($operations as $operationId => $tag) {
                $request = $this->apiDirectory . '/' . $suffix . '/' . $tag . '/Requests/' . $operationId . 'Request.php';
                $api = $this->apiDirectory . '/' . $suffix . '/' . $tag . '/' . $tag . 'Api.php';
                $source = is_file($api) ? file_get_contents($api) : false;

                if (isset($manifest[$operationId]) && is_file($request) && is_string($source) && str_contains($source, "operationId: '" . $operationId . "'")) {
                    $implemented++;
                } else {
                    $errors[] = sprintf('v%s is missing operation %s (%s).', $version, $operationId, $tag);
                }
            }

            foreach ($definitions as $name => $unused) {
                if ( ! is_string($name)) {
                    continue;
                }

                $class = $schemas[$name] ?? null;
                $file = is_string($class) ? $this->apiDirectory . '/' . $suffix . '/Schemas/' . $class . '.php' : '';

                if ( ! is_string($class) || ! is_file($file)) {
                    $errors[] = sprintf('v%s is missing schema %s.', $version, $name);
                }
            }

            foreach ($this->specs->unresolvedReferences($spec) as $reference) {
                $errors[] = sprintf('v%s has unresolved reference %s.', $version, $reference);
            }

            sort($tags);
            sort($manifestTags);

            if ($tags !== $manifestTags) {
                $errors[] = sprintf('v%s generated tags do not match the specification.', $version);
            }

            $count = count($operations);
            $rows[] = [$version, $count, $implemented, number_format(0 === $count ? 100 : ($implemented / $count) * 100, 2) . '%', count($definitions), count($schemas)];
        }

        return ['rows' => $rows, 'errors' => $errors];
    }

    /** @return array{array<string, string>, list<string>} */
    private function operations(array $spec): array
    {
        $operations = [];
        $tags = [];

        foreach ($spec['paths'] as $pathItem) {
            if ( ! is_array($pathItem)) {
                continue;
            }

            foreach (['delete', 'get', 'head', 'patch', 'post', 'put'] as $method) {
                $operation = $pathItem[$method] ?? null;

                if ( ! is_array($operation) || ! is_string($operation['operationId'] ?? null)) {
                    continue;
                }

                $tag = $operation['tags'][0] ?? null;
                $operations[$operation['operationId']] = is_string($tag) ? $tag : '';

                if (is_string($tag)) {
                    $tags[$tag] = true;
                }
            }
        }

        return [$operations, array_keys($tags)];
    }
}
