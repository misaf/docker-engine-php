<?php

declare(strict_types=1);

namespace Misaf\DockerEngine\Tools\Generator;

use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

final class DockerApiGenerator
{
    private const string ROOT_NAMESPACE = 'Misaf\DockerEngine\\Api';

    public function __construct(private readonly Filesystem $filesystem = new Filesystem()) {}

    /** @var array<string, string> */
    private const LEGACY_CLIENT_GROUPS = [
        'swarm'        => 'Swarm',
        'nodes'        => 'Node',
        'services'     => 'Service',
        'tasks'        => 'Task',
        'secrets'      => 'Secret',
        'configs'      => 'Config',
        'plugins'      => 'Plugin',
        'distribution' => 'Distribution',
        'session'      => 'Session',
    ];

    /** @var array<string, mixed> */
    private array $spec = [];

    /** @var array<string, array<string, mixed>> */
    private array $definitions = [];

    private string $versionNamespace = '';

    private string $outputDirectory = '';

    /** @var array<string, string> */
    private array $schemaClasses = [];

    /** @var array<string, string> */
    private const SUPPORT_FILES = [
        'ConnectionUpgrade.php' => 'ConnectionUpgrade.tpl.php',
        'Endpoint.php'          => 'Endpoint.tpl.php',
        'GeneratedApi.php'      => 'GeneratedApi.tpl.php',
        'ResponseKind.php'      => 'ResponseKind.tpl.php',
    ];

    /** @var array<string, string> */
    private const VALUE_OBJECTS = [
        'Container' => '\\Misaf\DockerEngine\ValueObjects\\ContainerId',
        'Exec'      => '\\Misaf\DockerEngine\\ValueObjects\\ExecId',
        'Network'   => '\\Misaf\DockerEngine\\ValueObjects\\NetworkId',
        'Volume'    => '\\Misaf\DockerEngine\\ValueObjects\\VolumeName',
        'Service'   => '\\Misaf\DockerEngine\\ValueObjects\\ServiceId',
        'Node'      => '\\Misaf\DockerEngine\\ValueObjects\\NodeId',
        'Task'      => '\\Misaf\DockerEngine\\ValueObjects\\TaskId',
        'Secret'    => '\\Misaf\DockerEngine\\ValueObjects\\SecretId',
        'Config'    => '\\Misaf\DockerEngine\\ValueObjects\\ConfigId',
        'Plugin'    => '\\Misaf\DockerEngine\\ValueObjects\\PluginName',
        'Image'     => '\\Misaf\DockerEngine\ValueObjects\\ImageReference',
    ];

    /** @var array<string, string> */
    private const METHOD_OVERRIDES = [
        'BuildPrune'               => 'pruneBuildCache',
        'ContainerArchive'         => 'archive',
        'ContainerArchiveInfo'     => 'archiveInfo',
        'ContainerDelete'          => 'remove',
        'ContainerExec'            => 'create',
        'GetPluginPrivileges'      => 'privileges',
        'ImageDelete'              => 'remove',
        'NetworkDelete'            => 'remove',
        'NodeDelete'               => 'remove',
        'PluginDelete'             => 'remove',
        'PutContainerArchive'      => 'putArchive',
        'SecretDelete'             => 'remove',
        'ServiceDelete'            => 'remove',
        'SwarmUnlockkey'           => 'unlockKey',
        'ConfigDelete'             => 'remove',
        'VolumeDelete'             => 'remove',
    ];

    /** @var list<string> */
    private const PROGRESS_OPERATIONS = [
        'ImageBuild',
        'ImageCreate',
        'ImageLoad',
        'ImagePush',
        'PluginPull',
        'PluginUpgrade',
    ];

    /** @var list<string> */
    private const UPGRADE_OPERATIONS = [
        'ContainerAttach',
        'ExecStart',
        'Session',
    ];

    /** @var list<string> */
    private const STREAM_OPERATIONS = [
        'ContainerAttachWebsocket',
        'ContainerStats',
    ];

    public function generate(string $version, string $specFile, string $sourceDirectory): void
    {
        $parsed = Yaml::parseFile($specFile);

        if ( ! is_array($parsed)) {
            throw new RuntimeException('Unable to parse ' . $specFile);
        }

        $this->spec = $parsed;
        $definitions = $parsed['definitions'] ?? null;

        if ( ! is_array($definitions)) {
            throw new RuntimeException($specFile . ' contains no Swagger definitions.');
        }

        /** @var array<string, array<string, mixed>> $definitions */
        $this->definitions = $definitions;
        $this->versionNamespace = self::ROOT_NAMESPACE . '\\V' . str_replace('.', '_', $version);
        $this->outputDirectory = mb_rtrim($sourceDirectory, '/') . '/V' . str_replace('.', '_', $version);
        $this->schemaClasses = [];

        $this->filesystem->remove($this->outputDirectory);
        $this->filesystem->mkdir($this->outputDirectory . '/Schemas');

        foreach (array_keys($this->definitions) as $name) {
            $this->schemaClasses[$name] = $this->className($name);
        }

        foreach ($this->definitions as $name => $definition) {
            $this->write(
                $this->outputDirectory . '/Schemas/' . $this->schemaClasses[$name] . '.php',
                $this->schemaSource($name, $definition),
            );
        }

        $operations = $this->operations();
        $byTag = [];

        foreach ($operations as $operation) {
            $tag = $operation['tag'];
            $byTag[$tag][] = $operation;
            $this->filesystem->mkdir($this->outputDirectory . '/' . $tag . '/Requests');
            $this->filesystem->mkdir($this->outputDirectory . '/' . $tag . '/Responses');
            $this->write(
                $this->outputDirectory . '/' . $tag . '/Requests/' . $operation['operationId'] . 'Request.php',
                $this->requestSource($operation),
            );

            $response = $this->responseInfo($operation);

            if (null !== $response['class']) {
                $this->write(
                    $this->outputDirectory . '/' . $tag . '/Responses/' . $operation['operationId'] . 'Response.php',
                    $this->responseSource($operation, $response),
                );
            }
        }

        ksort($byTag);

        foreach ($byTag as $tag => $tagOperations) {
            $this->write(
                $this->outputDirectory . '/' . $tag . '/' . $tag . 'Api.php',
                $this->apiSource($tag, $tagOperations),
            );
        }

        $this->write($this->outputDirectory . '/ApiSet.php', $this->apiSetSource(array_keys($byTag)));
        $this->write($this->outputDirectory . '/Manifest.php', $this->manifestSource($version, $operations, array_keys($byTag)));
    }

    public function generateSupport(string $outputDirectory): void
    {
        $templateDirectory = dirname(__DIR__) . '/templates/Generated';

        foreach (self::SUPPORT_FILES as $outputFile => $templateFile) {
            $source = file_get_contents($templateDirectory . '/' . $templateFile);

            if (false === $source) {
                throw new RuntimeException('Unable to read generated support template ' . $templateFile . '.');
            }

            $this->write(mb_rtrim($outputDirectory, '/') . '/' . $outputFile, $source);
        }
    }

    /** @param list<string> $versions */
    public function generateClient(array $versions, string $path): void
    {
        $apiSetTypes = [];
        $matches = [];

        foreach ($versions as $version) {
            $suffix = str_replace('.', '_', $version);
            $apiSetTypes[] = '\\' . self::ROOT_NAMESPACE . '\\V' . $suffix . '\\ApiSet';
            $matches[] = '            ApiVersion::V' . $suffix . ' => new \\' . self::ROOT_NAMESPACE . '\\V' . $suffix . "\\ApiSet(\$transport, \$this->version, \$this->serializer, \$this->errors),";
        }

        $legacyGroupMethods = [];

        foreach (self::LEGACY_CLIENT_GROUPS as $publicName => $tag) {
            $returnTypes = [];

            foreach ($versions as $version) {
                $returnTypes[] = '\\' . self::ROOT_NAMESPACE . '\\V' . str_replace('.', '_', $version) . '\\' . $tag . '\\' . $tag . 'Api';
            }

            $apiSetMethod = lcfirst($tag);
            $legacyGroupMethods[] = "    /** @deprecated Use versioned()->api()->" . $apiSetMethod . "(). */\n"
                . '    public function ' . $publicName . '(): ' . implode("\n        |", $returnTypes)
                . "\n    {\n        return \$this->versioned->api()->" . $apiSetMethod . "();\n    }\n";
        }

        $source = $this->header('Misaf\DockerEngine')
            . "use Misaf\DockerEngine\\Configuration\\ClientOptions;\n"
            . "use Misaf\DockerEngine\\Configuration\\TimeoutOptions;\n"
            . "use Misaf\DockerEngine\\Contracts\\Api\\ContainerApi;\n"
            . "use Misaf\DockerEngine\\Contracts\\Api\\ExecApi;\n"
            . "use Misaf\DockerEngine\\Contracts\\Api\\ImageApi;\n"
            . "use Misaf\DockerEngine\\Contracts\\Api\\NetworkApi;\n"
            . "use Misaf\DockerEngine\\Contracts\\Serializer;\n"
            . "use Misaf\DockerEngine\\Contracts\\Api\\SystemApi;\n"
            . "use Misaf\DockerEngine\\Contracts\\Transport;\n"
            . "use Misaf\DockerEngine\\Contracts\\Api\\VolumeApi;\n"
            . "use Misaf\DockerEngine\\Engine\\CapabilityDetector;\n"
            . "use Misaf\DockerEngine\\Engine\\EngineCapabilities;\n"
            . "use Misaf\DockerEngine\\Raw\\RawApi;\n"
            . "use Misaf\DockerEngine\\Resources\\Containers;\n"
            . "use Misaf\DockerEngine\\Resources\\Exec;\n"
            . "use Misaf\DockerEngine\\Resources\\Images;\n"
            . "use Misaf\DockerEngine\\Resources\\Networks;\n"
            . "use Misaf\DockerEngine\\Resources\\System;\n"
            . "use Misaf\DockerEngine\\Resources\\Volumes;\n"
            . "use Misaf\DockerEngine\\Serialization\\SymfonySerializer;\n"
            . "use Misaf\DockerEngine\\Transport\\Symfony\\SymfonyTransport;\n"
            . "use Misaf\DockerEngine\\Transport\\TlsOptions;\n\n"
            . "/** Stable SDK entry point with explicit access to generated APIs. */\n"
            . "final class DockerClient\n{\n"
            . "    private readonly Serializer \$serializer;\n\n"
            . "    private readonly ErrorMapper \$errors;\n\n"
            . "    private readonly ApiVersion \$version;\n\n"
            . "    private readonly VersionedApi \$versioned;\n\n"
            . "    private ?RawApi \$raw = null;\n\n"
            . "    private ?ContainerApi \$containers = null;\n\n"
            . "    private ?ImageApi \$images = null;\n\n"
            . "    private ?NetworkApi \$networks = null;\n\n"
            . "    private ?VolumeApi \$volumes = null;\n\n"
            . "    private ?ExecApi \$exec = null;\n\n"
            . "    private ?SystemApi \$system = null;\n\n"
            . "    private ?EngineCapabilities \$capabilities = null;\n\n"
            . "    public function __construct(\n        private readonly Transport \$transport,\n        ?ApiVersion \$version = null,\n        ?Serializer \$serializer = null,\n    ) {\n"
            . "        \$this->serializer = \$serializer ?? new SymfonySerializer();\n"
            . "        \$this->errors = new ErrorMapper();\n"
            . "        \$this->version = \$version ?? new VersionNegotiator(\$transport, \$this->errors)->negotiate();\n"
            . "        \$this->versioned = new VersionedApi(match (\$this->version) {\n" . implode("\n", $matches) . "\n        });\n    }\n\n"
            . "    public static function create(\n        string \$host = 'unix:///var/run/docker.sock',\n        ?ApiVersion \$version = null,\n        int \$timeoutSeconds = 60,\n        ?TlsOptions \$tls = null,\n        ?Serializer \$serializer = null,\n    ): self {\n"
            . "        return self::fromOptions(ClientOptions::resolve([\n            'host'        => \$host,\n            'api_version' => \$version,\n            'timeouts'    => new TimeoutOptions(request: \$timeoutSeconds),\n            'tls'         => \$tls,\n        ]), \$serializer);\n    }\n\n"
            . "    public static function fromOptions(ClientOptions \$options, ?Serializer \$serializer = null): self\n    {\n        \$serializer ??= new SymfonySerializer();\n        \$transport = new SymfonyTransport(\$options, \$serializer);\n\n        return new self(\$transport, \$options->apiVersion, \$serializer);\n    }\n\n"
            . "    public function version(): ApiVersion\n    {\n        return \$this->version;\n    }\n\n"
            . "    public function raw(): RawApi\n    {\n        return \$this->raw ??= new RawApi(\$this->transport, \$this->version, \$this->errors);\n    }\n\n"
            . "    public function versioned(): VersionedApi\n    {\n        return \$this->versioned;\n    }\n\n"
            . "    public function containers(): ContainerApi\n    {\n        return \$this->containers ??= new Containers(\$this->raw());\n    }\n\n"
            . "    public function images(): ImageApi\n    {\n        return \$this->images ??= new Images(\$this->raw());\n    }\n\n"
            . "    public function networks(): NetworkApi\n    {\n        return \$this->networks ??= new Networks(\$this->raw());\n    }\n\n"
            . "    public function volumes(): VolumeApi\n    {\n        return \$this->volumes ??= new Volumes(\$this->raw());\n    }\n\n"
            . "    public function exec(): ExecApi\n    {\n        return \$this->exec ??= new Exec(\$this->raw());\n    }\n\n"
            . "    public function system(): SystemApi\n    {\n        return \$this->system ??= new System(\$this->raw());\n    }\n"
            . "\n" . implode("\n", $legacyGroupMethods)
            . "\n    public function capabilities(): EngineCapabilities\n    {\n        return \$this->capabilities ??= new CapabilityDetector(\$this->raw(), \$this->version)->detect();\n    }\n"
            . "}\n";

        $this->write($path, $source);
        $this->write(dirname($path) . '/VersionedApi.php', $this->versionedApiSource($apiSetTypes));
    }

    /** @param list<string> $apiSetTypes */
    private function versionedApiSource(array $apiSetTypes): string
    {
        $union = implode("\n        |", $apiSetTypes);

        return $this->header('Misaf\DockerEngine')
            . "/**\n"
            . " * Deliberate gateway to the exact OpenAPI-generated API selected by negotiation.\n"
            . " *\n"
            . " * Consumers using this layer accept version-specific request and response DTOs.\n"
            . " */\n"
            . "final readonly class VersionedApi\n{\n"
            . "    public function __construct(private " . $union . " \$api) {}\n\n"
            . "    public function api(): " . $union . "\n    {\n"
            . "        return \$this->api;\n"
            . "    }\n"
            . "}\n";
    }

    /** @return list<array{operationId: string, tag: string, method: string, path: string, definition: array<string, mixed>, parameters: list<array<string, mixed>>}> */
    private function operations(): array
    {
        $operations = [];
        $paths = $this->spec['paths'] ?? [];

        if ( ! is_array($paths)) {
            return [];
        }

        foreach ($paths as $path => $pathItem) {
            if ( ! is_string($path) || ! is_array($pathItem)) {
                continue;
            }

            foreach (['delete', 'get', 'head', 'patch', 'post', 'put'] as $method) {
                $definition = $pathItem[$method] ?? null;

                if ( ! is_array($definition)) {
                    continue;
                }

                $operationId = $definition['operationId'] ?? null;
                $tag = $definition['tags'][0] ?? null;

                if ( ! is_string($operationId) || ! is_string($tag)) {
                    throw new RuntimeException(sprintf('%s %s has no operationId or tag.', mb_strtoupper($method), $path));
                }

                $parameters = [];

                foreach ([...($pathItem['parameters'] ?? []), ...($definition['parameters'] ?? [])] as $parameter) {
                    if ( ! is_array($parameter)) {
                        continue;
                    }

                    $parameters[] = $this->resolveParameter($parameter);
                }

                $operations[] = [
                    'operationId' => $operationId,
                    'tag'         => $tag,
                    'method'      => mb_strtoupper($method),
                    'path'        => $path,
                    'definition'  => $definition,
                    'parameters'  => $parameters,
                ];
            }
        }

        usort($operations, static fn(array $left, array $right): int => [$left['tag'], $left['operationId']] <=> [$right['tag'], $right['operationId']]);

        return $operations;
    }

    /** @param array<string, mixed> $parameter @return array<string, mixed> */
    private function resolveParameter(array $parameter): array
    {
        $reference = $parameter['$ref'] ?? null;

        if ( ! is_string($reference)) {
            return $parameter;
        }

        $name = basename(str_replace('\\', '/', $reference));
        $resolved = $this->spec['parameters'][$name] ?? null;

        if ( ! is_array($resolved)) {
            throw new RuntimeException('Unresolvable parameter reference ' . $reference);
        }

        return $resolved;
    }

    /** @param array<string, mixed> $definition */
    private function schemaSource(string $name, array $definition): string
    {
        $namespace = $this->versionNamespace . '\\Schemas';
        $class = $this->schemaClasses[$name];
        $description = $this->description($definition['description'] ?? null);

        if (isset($definition['enum']) && is_array($definition['enum'])) {
            return $this->enumSource($namespace, $class, $definition, $description);
        }

        $properties = $this->schemaProperties($definition);

        return $this->objectSource($namespace, $class, $properties, $description, false);
    }

    /** @param array<string, mixed> $definition */
    private function enumSource(string $namespace, string $class, array $definition, string $description): string
    {
        $type = 'integer' === ($definition['type'] ?? null) ? 'int' : 'string';
        $cases = [];
        $used = [];

        foreach ($definition['enum'] as $index => $value) {
            if ( ! is_string($value) && ! is_int($value)) {
                continue;
            }

            $case = $this->enumCase((string) $value, (int) $index);

            while (isset($used[mb_strtolower($case)])) {
                $case .= 'Value';
            }

            $used[mb_strtolower($case)] = true;
            $cases[] = '    case ' . $case . ' = ' . self::phpLiteral($value) . ';';
        }

        return $this->header($namespace)
            . $description
            . 'enum ' . $class . ': ' . $type . "\n{\n"
            . implode("\n", $cases) . "\n}\n";
    }

    /** @param list<array{name: string, schema: array<string, mixed>, required: bool}> $properties */
    private function objectSource(string $namespace, string $class, array $properties, string $description, bool $final): string
    {
        $parameters = [];
        $docs = [];

        usort($properties, static fn(array $left, array $right): int => ($right['required'] <=> $left['required']));

        foreach ($properties as $property) {
            $wireName = $property['name'];
            $propertyName = $this->propertyName($wireName);
            $type = $this->type($property['schema']);
            $phpType = $type['php'];

            if (($property['schema']['x-nullable'] ?? false) && ! str_contains($phpType, 'null') && 'mixed' !== $phpType) {
                $phpType .= '|null';
            }

            if ( ! $property['required'] && 'mixed' !== $phpType) {
                $phpType .= '|Undefined';
            }

            if (null !== $type['doc']) {
                $docs[] = '     * @param ' . $type['doc'] . ($property['required'] ? '' : '|Undefined') . ' $' . $propertyName;
            }

            $attributes = ["        #[SerializedName(" . self::phpLiteral($wireName) . ')]'];

            if (null !== $type['arrayOf']) {
                $attributes[] = '        #[ArrayOf(' . $type['arrayOf'] . '::class)]';
            }

            $default = $property['required'] ? '' : ' = Undefined::Value';
            $parameters[] = implode("\n", $attributes)
                . "\n        public " . $phpType . ' $' . $propertyName . $default . ',';
        }

        $imports = "use Misaf\DockerEngine\\Serialization\\ArrayOf;\n"
            . "use Misaf\DockerEngine\\Serialization\\Undefined;\n"
            . "use Symfony\\Component\\Serializer\\Attribute\\SerializedName;\n\n";
        $constructorDoc = [] === $docs ? '' : "/**\n" . implode("\n", $docs) . "\n     */\n    ";
        $modifier = $final ? 'final readonly class ' : 'readonly class ';

        if ([] === $parameters) {
            return $this->header($namespace) . $imports . $description . $modifier . $class . "\n{\n    public function __construct() {}\n}\n";
        }

        return $this->header($namespace)
            . $imports
            . $description
            . $modifier . $class . "\n{\n    " . $constructorDoc . "public function __construct(\n"
            . implode("\n", $parameters)
            . "\n    ) {}\n}\n";
    }

    /** @param array<string, mixed> $definition @return list<array{name: string, schema: array<string, mixed>, required: bool}> */
    private function schemaProperties(array $definition, array $seen = []): array
    {
        $properties = [];
        $required = is_array($definition['required'] ?? null) ? $definition['required'] : [];

        foreach ($definition['allOf'] ?? [] as $part) {
            if ( ! is_array($part)) {
                continue;
            }

            $reference = $part['$ref'] ?? null;

            if (is_string($reference)) {
                $name = $this->referenceName($reference);

                if (isset($seen[$name])) {
                    continue;
                }

                $seen[$name] = true;
                $part = $this->definitions[$name] ?? [];
            }

            foreach ($this->schemaProperties($part, $seen) as $property) {
                $properties[$property['name']] = $property;
            }
        }

        foreach ($definition['properties'] ?? [] as $name => $schema) {
            if (is_string($name) && is_array($schema)) {
                $properties[$name] = [
                    'name'     => $name,
                    'schema'   => $schema,
                    'required' => in_array($name, $required, true),
                ];
            }
        }

        return array_values($properties);
    }

    /** @param array<string, mixed> $operation */
    private function requestSource(array $operation): string
    {
        $tag = $operation['tag'];
        $operationId = $operation['operationId'];
        $namespace = $this->versionNamespace . '\\' . $tag . '\\Requests';
        $parameters = [];
        $docs = [];
        $used = [];

        foreach ($operation['parameters'] as $parameter) {
            $wireName = $parameter['name'] ?? null;
            $location = $parameter['in'] ?? null;

            if ( ! is_string($wireName) || ! is_string($location)) {
                continue;
            }

            $name = $this->propertyName($wireName);

            while (isset($used[$name])) {
                $name .= 'Value';
            }

            $used[$name] = true;
            $schema = 'body' === $location && is_array($parameter['schema'] ?? null) ? $parameter['schema'] : $parameter;
            $type = $this->type($schema);
            $phpType = $type['php'];
            $docType = $type['doc'];

            if ('body' === $location && 'string' === ($schema['type'] ?? null) && 'binary' === ($schema['format'] ?? null)) {
                $phpType = 'string|\\Misaf\DockerEngine\\Contracts\\Stream\\Stream';
                $docType = 'string|\\Misaf\DockerEngine\\Contracts\\Stream\\Stream';
            }

            if ('path' === $location && 'id' === mb_strtolower($wireName) && isset(self::VALUE_OBJECTS[$tag])) {
                $phpType = 'string|' . self::VALUE_OBJECTS[$tag];
            } elseif ('path' === $location && 'name' === mb_strtolower($wireName) && isset(self::VALUE_OBJECTS[$tag])) {
                $phpType = 'string|' . self::VALUE_OBJECTS[$tag];
            }

            $required = true === ($parameter['required'] ?? false);

            if (($schema['x-nullable'] ?? false) && ! str_contains($phpType, 'null') && 'mixed' !== $phpType) {
                $phpType .= '|null';
            }

            if ( ! $required && 'mixed' !== $phpType) {
                $phpType .= '|Undefined';
            }

            if (null !== $docType) {
                $docs[] = '     * @param ' . $docType . ($required ? '' : '|Undefined') . ' $' . $name;
            }

            $attributes = [
                '        #[RequestParameter(' . self::phpLiteral($wireName) . ', ' . self::phpLiteral($location) . ', ' . self::phpLiteral('multi' === ($parameter['collectionFormat'] ?? null)) . ')]',
            ];

            if (null !== $type['arrayOf']) {
                $attributes[] = '        #[ArrayOf(' . $type['arrayOf'] . '::class)]';
            }

            $parameters[] = [
                'required' => $required,
                'source'   => implode("\n", $attributes) . "\n        public " . $phpType . ' $' . $name . ($required ? '' : ' = Undefined::Value') . ',',
            ];
        }

        usort($parameters, static fn(array $left, array $right): int => $right['required'] <=> $left['required']);
        $imports = "use Misaf\DockerEngine\\Generated\\GeneratedRequest;\n"
            . "use Misaf\DockerEngine\\Generated\\RequestParameter;\n"
            . "use Misaf\DockerEngine\\Serialization\\ArrayOf;\n"
            . "use Misaf\DockerEngine\\Serialization\\Undefined;\n\n";

        if ([] === $parameters) {
            return $this->header($namespace) . $imports . 'final readonly class ' . $operationId . "Request extends GeneratedRequest {}\n";
        }

        $constructorDoc = [] === $docs ? '' : "/**\n" . implode("\n", $docs) . "\n     */\n    ";

        return $this->header($namespace)
            . $imports
            . 'final readonly class ' . $operationId . "Request extends GeneratedRequest\n{\n    "
            . $constructorDoc . "public function __construct(\n"
            . implode("\n", array_column($parameters, 'source'))
            . "\n    ) {}\n}\n";
    }

    /** @param array<string, mixed> $operation @return array{class: ?string, kind: string, schema: ?array<string, mixed>, extends: ?string} */
    private function responseInfo(array $operation): array
    {
        $definition = $operation['definition'];
        $response = null;

        foreach ($definition['responses'] ?? [] as $status => $candidate) {
            if (str_starts_with((string) $status, '2') && is_array($candidate)) {
                $response = $candidate;

                break;
            }
        }

        $schema = is_array($response['schema'] ?? null) ? $response['schema'] : null;
        $produces = $response['produces'][0] ?? $definition['produces'][0] ?? $this->spec['produces'][0] ?? 'application/json';
        $operationId = $operation['operationId'];

        if (in_array($operationId, self::STREAM_OPERATIONS, true)) {
            return ['class' => null, 'kind' => 'stream', 'schema' => $schema, 'extends' => null];
        }

        if (in_array($operationId, self::PROGRESS_OPERATIONS, true)) {
            return ['class' => null, 'kind' => 'progress', 'schema' => $schema, 'extends' => null];
        }

        if ('application/vnd.docker.raw-stream' === $produces || 'application/jsonl' === $produces
            || str_contains((string) $produces, 'application/x-tar') || 'application/octet-stream' === $produces
            || ('string' === ($schema['type'] ?? null) && 'binary' === ($schema['format'] ?? null))) {
            return ['class' => null, 'kind' => 'stream', 'schema' => $schema, 'extends' => null];
        }

        if (null === $schema) {
            return ['class' => null, 'kind' => 'void', 'schema' => null, 'extends' => null];
        }

        if ('string' === ($schema['type'] ?? null) || 'integer' === ($schema['type'] ?? null) || 'boolean' === ($schema['type'] ?? null)) {
            return ['class' => null, 'kind' => 'raw', 'schema' => $schema, 'extends' => null];
        }

        $extends = null;

        if (is_string($schema['$ref'] ?? null)) {
            $reference = $this->referenceName($schema['$ref']);
            $referenced = $this->definitions[$reference] ?? [];

            if ( ! isset($referenced['enum']) && ! $this->isArrayLike($referenced)) {
                $extends = '\\' . $this->versionNamespace . '\\Schemas\\' . $this->schemaClasses[$reference];
            }
        }

        return [
            'class'   => $operationId . 'Response',
            'kind'    => 'array' === ($schema['type'] ?? null) ? 'json-array' : 'json',
            'schema'  => $schema,
            'extends' => $extends,
        ];
    }

    /** @param array<string, mixed> $operation @param array{class: ?string, kind: string, schema: ?array<string, mixed>, extends: ?string} $response */
    private function responseSource(array $operation, array $response): string
    {
        $namespace = $this->versionNamespace . '\\' . $operation['tag'] . '\\Responses';
        $class = (string) $response['class'];
        $schema = $response['schema'] ?? [];

        if (null !== $response['extends']) {
            return $this->header($namespace)
                . 'final readonly class ' . $class . ' extends ' . $response['extends'] . " {}\n";
        }

        if ('array' === ($schema['type'] ?? null) || (is_string($schema['$ref'] ?? null) && $this->isArrayLike($this->definitions[$this->referenceName($schema['$ref'])] ?? []))) {
            $itemSchema = is_array($schema['items'] ?? null) ? $schema['items'] : ['type' => 'mixed'];
            $type = $this->type($itemSchema);
            $arrayOf = null === $type['arrayOf'] && str_starts_with($type['php'], '\\') ? $type['php'] : $type['arrayOf'];
            $attribute = null === $arrayOf ? '' : "        #[\\Misaf\DockerEngine\\Serialization\\ArrayOf(" . $arrayOf . "::class)]\n";
            $doc = null === $type['doc'] ? 'list<mixed>' : 'list<' . $type['doc'] . '>';

            return $this->header($namespace)
                . 'final readonly class ' . $class . "\n{\n"
                . "    /** @param " . $doc . " \$items */\n"
                . "    public function __construct(\n" . $attribute . "        public array \$items,\n    ) {}\n}\n";
        }

        if (is_string($schema['$ref'] ?? null)) {
            $type = $this->type($schema);

            return $this->header($namespace)
                . 'final readonly class ' . $class . "\n{\n    public function __construct(public " . $type['php'] . " \$value) {}\n}\n";
        }

        return $this->objectSource(
            $namespace,
            $class,
            $this->schemaProperties($schema),
            $this->description($operation['definition']['summary'] ?? null),
            true,
        );
    }

    /** @param list<array<string, mixed>> $operations */
    private function apiSource(string $tag, array $operations): string
    {
        $namespace = $this->versionNamespace . '\\' . $tag;
        $methods = [];

        foreach ($operations as $operation) {
            $methods[] = $this->apiMethodSource($operation);
        }

        $baseClass = match ($tag) {
            'Exec'  => 'GeneratedExecApi',
            'Image' => 'GeneratedImageApi',
            default => 'GeneratedApi',
        };

        return $this->header($namespace)
            . "use Misaf\DockerEngine\\Generated\\ConnectionUpgrade;\n"
            . "use Misaf\DockerEngine\\Generated\\Endpoint;\n"
            . "use Misaf\DockerEngine\\Generated\\GeneratedApi;\n"
            . "use Misaf\DockerEngine\\Generated\\GeneratedExecApi;\n"
            . "use Misaf\DockerEngine\\Generated\\GeneratedImageApi;\n"
            . "use Misaf\DockerEngine\\Generated\\ResponseKind;\n"
            . "use Misaf\DockerEngine\\Exceptions\\InvalidResponseException;\n"
            . "use Misaf\DockerEngine\\Streaming\\ProgressStream;\n"
            . "use Misaf\DockerEngine\\Transport\\StreamResponse;\n\n"
            . 'final class ' . $tag . 'Api extends ' . $baseClass . "\n{\n"
            . implode("\n", $methods)
            . "}\n";
    }

    /** @param array<string, mixed> $operation */
    private function apiMethodSource(array $operation): string
    {
        $response = $this->responseInfo($operation);
        $operationId = $operation['operationId'];
        $tag = $operation['tag'];
        $method = $this->methodName($operationId, $tag);
        $requestClass = '\\' . $this->versionNamespace . '\\' . $tag . '\\Requests\\' . $operationId . 'Request';
        $hasRequired = false;
        $requiredParameters = [];

        foreach ($operation['parameters'] as $parameter) {
            $hasRequired = $hasRequired || true === ($parameter['required'] ?? false);

            if (true === ($parameter['required'] ?? false)) {
                $requiredParameters[] = $parameter;
            }
        }

        $hasParameters = [] !== $operation['parameters'];
        $convenienceParameter = 1 === count($requiredParameters) && 'path' === ($requiredParameters[0]['in'] ?? null)
            ? $requiredParameters[0]
            : null;
        $prepare = '';

        if (is_array($convenienceParameter) && is_string($convenienceParameter['name'] ?? null)) {
            $wireName = $convenienceParameter['name'];
            $schema = $convenienceParameter;
            $parameterType = $this->type($schema)['php'];

            if (in_array(mb_strtolower($wireName), ['id', 'name'], true) && isset(self::VALUE_OBJECTS[$tag])) {
                $parameterType = 'string|' . self::VALUE_OBJECTS[$tag];
            }

            $argument = $requestClass . '|' . $parameterType . ' $request';
            $prepare = "        \$request = \$request instanceof " . $requestClass . "\n            ? \$request\n            : new " . $requestClass . '(' . $this->propertyName($wireName) . ": \$request);\n\n";
        } else {
            $argument = ! $hasParameters ? '' : ($hasRequired ? $requestClass . ' $request' : '?' . $requestClass . ' $request = null');
        }

        $input = $hasParameters ? ', $request' : '';
        $responseClass = null === $response['class'] ? 'null' : '\\' . $this->versionNamespace . '\\' . $tag . '\\Responses\\' . $response['class'] . '::class';
        $deprecated = true === ($operation['definition']['deprecated'] ?? false);
        $doc = $deprecated ? "    /** @deprecated Deprecated by Docker in this API version. */\n" : '';
        $upgrade = match (true) {
            'ContainerAttachWebsocket' === $operationId            => 'ConnectionUpgrade::WebSocket',
            in_array($operationId, self::UPGRADE_OPERATIONS, true) => 'ConnectionUpgrade::Tcp',
            default                                                => 'null',
        };
        $responseKind = match ($response['kind']) {
            'json'       => 'ResponseKind::Json',
            'json-array' => 'ResponseKind::JsonArray',
            'progress'   => 'ResponseKind::Progress',
            'raw'        => 'ResponseKind::Raw',
            'stream'     => 'ResponseKind::Stream',
            'void'       => 'ResponseKind::Void',
            default      => throw new RuntimeException('Unsupported response kind ' . $response['kind'] . '.'),
        };
        $endpoint = "new Endpoint(\n            operationId: '" . $operationId . "',\n            method: '" . $operation['method'] . "',\n            path: '" . str_replace("'", "\\'", $operation['path']) . "',\n            responseClass: " . $responseClass . ",\n            responseKind: " . $responseKind . ",\n            deprecated: " . ($deprecated ? 'true' : 'false') . ",\n            upgrade: " . $upgrade . ",\n        )";

        if ('void' === $response['kind']) {
            return $doc . '    public function ' . $method . '(' . $argument . "): void\n    {\n" . $prepare . "        \$this->call(" . $endpoint . $input . ");\n    }\n";
        }

        if ('raw' === $response['kind']) {
            $return = match ($response['schema']['type'] ?? 'string') {
                'integer' => 'int',
                'boolean' => 'bool',
                default   => 'string',
            };

            return $doc . '    public function ' . $method . '(' . $argument . '): ' . $return . "\n    {\n" . $prepare . "        \$result = \$this->call(" . $endpoint . $input . ");\n\n        if ( ! is_string(\$result)) {\n            throw new InvalidResponseException('Docker operation " . $operationId . " did not return a primitive response.');\n        }\n\n        return " . match ($return) {
                'int'   => 'filter_var($result, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) ?? throw new InvalidResponseException(\'Docker returned a non-integer response.\')',
                'bool'  => 'filter_var($result, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) ?? throw new InvalidResponseException(\'Docker returned a non-boolean response.\')',
                default => '$result',
            } . ";\n    }\n";
        }

        if ('stream' === $response['kind'] || 'progress' === $response['kind']) {
            $return = 'stream' === $response['kind'] ? 'StreamResponse' : 'ProgressStream';

            return $doc . '    public function ' . $method . '(' . $argument . '): ' . $return . "\n    {\n" . $prepare . "        \$result = \$this->call(" . $endpoint . $input . ");\n\n        if ( ! \$result instanceof " . $return . ") {\n            throw new InvalidResponseException('Docker operation " . $operationId . " returned an unexpected response type.');\n        }\n\n        return \$result;\n    }\n";
        }

        $returnClass = '\\' . $this->versionNamespace . '\\' . $tag . '\\Responses\\' . $response['class'];

        return $doc . '    public function ' . $method . '(' . $argument . '): ' . $returnClass . "\n    {\n" . $prepare . "        \$result = \$this->call(" . $endpoint . $input . ");\n\n        if ( ! \$result instanceof " . $returnClass . ") {\n            throw new InvalidResponseException('Docker operation " . $operationId . " returned an unexpected response type.');\n        }\n\n        return \$result;\n    }\n";
    }

    /** @param list<string> $tags */
    private function apiSetSource(array $tags): string
    {
        sort($tags);
        $properties = [];
        $methods = [];
        $constructor = [];

        foreach ($tags as $tag) {
            $property = lcfirst($tag);
            $class = '\\' . $this->versionNamespace . '\\' . $tag . '\\' . $tag . 'Api';
            $properties[] = '    private ?' . $class . ' $' . $property . ' = null;';
            $methods[] = '    public function ' . $property . '(): ' . $class . "\n    {\n        return \$this->" . $property . ' ??= new ' . $class . "(\n            \$this->transport,\n            \$this->version,\n            \$this->serializer,\n            \$this->errors,\n        );\n    }\n";
        }

        return $this->header($this->versionNamespace)
            . "use Misaf\DockerEngine\\ApiVersion;\n"
            . "use Misaf\DockerEngine\\Contracts\\Serializer;\n"
            . "use Misaf\DockerEngine\\Contracts\\Transport;\n"
            . "use Misaf\DockerEngine\\ErrorMapper;\n\n"
            . "final class ApiSet\n{\n"
            . implode("\n", $properties) . "\n\n"
            . "    public function __construct(\n        private readonly Transport \$transport,\n        private readonly ApiVersion \$version,\n        private readonly Serializer \$serializer,\n        private readonly ErrorMapper \$errors,\n    ) {}\n\n"
            . implode("\n", $methods)
            . "}\n";
    }

    /** @param list<array<string, mixed>> $operations @param list<string> $tags */
    private function manifestSource(string $version, array $operations, array $tags): string
    {
        $operationRows = [];

        foreach ($operations as $operation) {
            $operationRows[] = "        '" . $operation['operationId'] . "' => ['tag' => '" . $operation['tag'] . "', 'method' => '" . $operation['method'] . "', 'path' => '" . str_replace("'", "\\'", $operation['path']) . "'],";
        }

        $schemaRows = [];

        foreach ($this->schemaClasses as $name => $class) {
            $schemaRows[] = "        '" . str_replace("'", "\\'", $name) . "' => '" . $class . "',";
        }

        sort($tags);

        return $this->header($this->versionNamespace)
            . "final class Manifest\n{\n"
            . "    public const string VERSION = '" . $version . "';\n\n"
            . "    /** @var array<string, array{tag: string, method: string, path: string}> */\n"
            . "    public const array OPERATIONS = [\n" . implode("\n", $operationRows) . "\n    ];\n\n"
            . "    /** @var array<string, string> */\n"
            . "    public const array SCHEMAS = [\n" . implode("\n", $schemaRows) . "\n    ];\n\n"
            . "    /** @var list<string> */\n"
            . '    public const array TAGS = ' . self::phpLiteral($tags) . ";\n}\n";
    }

    /** @param array<string, mixed> $schema @return array{php: string, doc: ?string, arrayOf: ?string} */
    private function type(array $schema): array
    {
        $reference = $schema['$ref'] ?? null;

        if (is_string($reference)) {
            $name = $this->referenceName($reference);
            $definition = $this->definitions[$name] ?? null;

            if (is_array($definition) && $this->isArrayLike($definition)) {
                return ['php' => 'array', 'doc' => 'array<array-key, mixed>', 'arrayOf' => null];
            }

            $class = '\\' . $this->versionNamespace . '\\Schemas\\' . ($this->schemaClasses[$name] ?? $this->className($name));

            return ['php' => $class, 'doc' => $class, 'arrayOf' => null];
        }

        if (isset($schema['allOf'][0]) && is_array($schema['allOf'][0])) {
            return $this->type($schema['allOf'][0]);
        }

        return match ($schema['type'] ?? 'mixed') {
            'array'   => $this->arrayType(is_array($schema['items'] ?? null) ? $schema['items'] : []),
            'boolean' => ['php' => 'bool', 'doc' => null, 'arrayOf' => null],
            'integer' => ['php' => 'int', 'doc' => null, 'arrayOf' => null],
            'number'  => ['php' => 'float', 'doc' => null, 'arrayOf' => null],
            'object'  => ['php' => 'array', 'doc' => 'array<string, mixed>', 'arrayOf' => null],
            'string'  => ['php' => 'string', 'doc' => null, 'arrayOf' => null],
            default   => ['php' => 'mixed', 'doc' => null, 'arrayOf' => null],
        };
    }

    /** @param array<string, mixed> $items @return array{php: string, doc: string, arrayOf: ?string} */
    private function arrayType(array $items): array
    {
        $item = $this->type($items);
        $docType = $item['doc'] ?? $item['php'];
        $arrayOf = str_starts_with($item['php'], '\\') && ! str_contains($item['php'], '|') ? $item['php'] : null;

        return ['php' => 'array', 'doc' => 'list<' . $docType . '>', 'arrayOf' => $arrayOf];
    }

    /** @param array<string, mixed> $definition */
    private function isArrayLike(array $definition): bool
    {
        return 'array' === ($definition['type'] ?? null)
            || ('object' === ($definition['type'] ?? null) && ! isset($definition['properties']) && isset($definition['additionalProperties']));
    }

    private function methodName(string $operationId, string $tag): string
    {
        if (isset(self::METHOD_OVERRIDES[$operationId])) {
            return self::METHOD_OVERRIDES[$operationId];
        }

        $suffix = str_starts_with($operationId, $tag) ? mb_substr($operationId, mb_strlen($tag)) : $operationId;

        return lcfirst('' === $suffix ? $operationId : $suffix);
    }

    private function propertyName(string $name): string
    {
        $name = preg_replace('/([A-Z]+)([A-Z][a-z])/', '$1_$2', $name) ?? $name;
        $name = preg_replace('/([a-z0-9])([A-Z])/', '$1_$2', $name) ?? $name;
        $parts = preg_split('/[^A-Za-z0-9]+/', $name, flags: PREG_SPLIT_NO_EMPTY) ?: ['value'];
        $property = mb_strtolower(array_shift($parts));

        foreach ($parts as $part) {
            $property .= ucfirst(mb_strtolower($part));
        }

        if (preg_match('/^[0-9]/', $property)) {
            $property = 'value' . $property;
        }

        return $property;
    }

    private function className(string $name): string
    {
        $parts = preg_split('/[^A-Za-z0-9]+/', $name, flags: PREG_SPLIT_NO_EMPTY) ?: ['Anonymous'];
        $class = implode('', array_map(static fn(string $part): string => ucfirst($part), $parts));

        return preg_match('/^[0-9]/', $class) ? 'Schema' . $class : $class;
    }

    private function enumCase(string $value, int $index): string
    {
        if ('' === $value) {
            return 'Empty';
        }

        $case = $this->className($value);

        if ('Anonymous' === $case || preg_match('/^[0-9]/', $case)) {
            return 'Value' . $index;
        }

        return $case;
    }

    private function referenceName(string $reference): string
    {
        return rawurldecode(mb_substr($reference, mb_strrpos($reference, '/') + 1));
    }

    private function description(mixed $description): string
    {
        if ( ! is_string($description) || '' === mb_trim($description)) {
            return '';
        }

        $line = mb_trim(strtok($description, "\n") ?: $description);
        $line = str_replace('*/', '* /', $line);

        return "/** " . $line . " */\n";
    }

    private function header(string $namespace): string
    {
        return "<?php\n\ndeclare(strict_types=1);\n\nnamespace " . $namespace . ";\n\n";
    }

    private static function phpLiteral(mixed $value): string
    {
        if (is_string($value)) {
            return "'" . str_replace(['\\', "'"], ['\\\\', "\\'"], $value) . "'";
        }

        if (is_int($value)) {
            return (string) $value;
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_array($value)) {
            return '[' . implode(', ', array_map(self::phpLiteral(...), $value)) . ']';
        }

        throw new RuntimeException('Unable to export unsupported generated PHP literal.');
    }

    private function write(string $path, string $contents): void
    {
        $this->filesystem->mkdir(dirname($path));
        $this->filesystem->dumpFile($path, $contents);
    }
}
