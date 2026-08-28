# Docker Engine PHP

A framework-neutral PHP 8.4 SDK for Docker Engine API v1.40 through v1.55. It talks directly to Docker-compatible Engine HTTP APIs over Unix sockets or HTTP/TLS. It never invokes Docker or Podman CLI commands.

## Installation

```bash
composer require misaf/docker-engine-php
```

## High-level SDK API

The default API is stable across negotiated Engine API versions. Common operations use SDK-owned request and result types rather than generated `V1_40` through `V1_55` schemas.

```php
use Misaf\DockerEngine\DockerClient;
use Misaf\DockerEngine\Dto\Container\CreateContainer;

$docker = DockerClient::create('unix:///var/run/docker.sock');

$created = $docker->containers()->create(new CreateContainer(
    image: 'nginx:latest',
    name: 'web',
));

$docker->containers()->start($created->id);
$containers = $docker->containers()->list();
$engine = $docker->system()->info();
```

Stable domain contracts are available for containers, images, networks, volumes, exec, and system operations. The SDK intentionally normalizes only frequently used concepts; it does not duplicate every Docker schema.

## Negotiation and version pinning

By default, the client reads the unversioned `/version` endpoint and selects the newest version shared by the daemon and this SDK. Stable DTOs remain the same even when the negotiated API version differs.

Pin a version when exact daemon behavior must be reproducible:

```php
use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\DockerClient;

$docker = DockerClient::create(
    host: 'http://docker.example.test:2375',
    version: ApiVersion::V1_50,
);
```

## Exact generated Docker API

Use the explicit versioned gateway when an operation or schema must exactly match the negotiated or pinned Docker API. This layer intentionally exposes generated, version-specific types.

```php
use Misaf\DockerEngine\Api\V1_55\Container\Requests\ContainerCreateRequest;
use Misaf\DockerEngine\Api\V1_55\Schemas\ContainerConfig;
use Misaf\DockerEngine\ApiVersion;

$docker = DockerClient::create(version: ApiVersion::V1_55);
$api = $docker->versioned()->api();

$created = $api->container()->create(new ContainerCreateRequest(
    body: new ContainerConfig(image: 'nginx:latest'),
    name: 'web',
));
```

Pin the client to the matching version whenever application code imports a generated DTO. The versioned gateway also contains the complete generated surface for Swarm, nodes, services, tasks, secrets, configs, plugins, distribution, and session endpoints.

For 1.x migration safety, the old top-level accessors for those secondary groups remain as deprecated forwarding aliases. New code should use the explicit versioned gateway.

Migration from the earlier 1.x API is mechanical:

```php
// Earlier generated access
$docker->containers()->inspect('web');

// Exact generated access now
$docker->versioned()->api()->container()->inspect('web');

// Preferred stable access
$docker->containers()->inspect('web');
```

The final example returns a stable `Dto\Container\ContainerInfo`; the exact generated call returns its selected version's generated response type.

## Raw API

`RawApi` is a supported, version-aware escape hatch for extensions, new endpoints, engine-specific behavior, and compatibility experiments:

```php
$response = $docker->raw()->request('GET', '/info');
$stream = $docker->raw()->stream('GET', '/events');
```

Pass `versioned: false` for unversioned endpoints such as custom discovery routes.

## Streaming and exec

Streaming responses are lazy. The SDK implements Docker multiplex framing, raw TTY streams, JSON-line progress, WebSocket framing, and upgraded socket streams directly over the Engine API.

```php
use Misaf\DockerEngine\Dto\Container\LogsOptions;

$logs = $docker->containers()->logs('web', new LogsOptions(tty: false));
$logs->consume(
    onStdout: static fn (string $chunk) => print $chunk,
    onStderr: static fn (string $chunk) => fwrite(STDERR, $chunk),
);

$result = $docker->exec()->run('web', ['php', '-v']);
$session = $docker->exec()->stream($result->execId);
$session->write("input\n");
$session->closeStdin();
$session->cancel();
```

TTY output is raw and cannot separate stderr. Non-TTY output uses Docker's multiplex headers. Stream timeouts come from `TimeoutOptions`; cancellation closes the active stream, and upgraded sockets support a write-side half-close for stdin EOF.

Stream wrappers close their underlying transport when consumption finishes, iteration stops early, or a consumer callback throws. They also expose `close()` and `cancel()` for explicit lifecycle ownership:

```php
$logs = $docker->containers()->logs('web');

try {
    foreach ($logs->frames() as $frame) {
        // Consume lazily; breaking is safe.
    }
} finally {
    $logs->cancel();
}
```

## Docker and Podman

Docker is the reference implementation. API-compatible Podman is tested in CI through its Docker-compatible socket. Capability detection uses `/version`, `/info`, and the negotiated API version to identify the implementation and expose a deliberately small extension point:

```php
$capabilities = $docker->capabilities();

if ($capabilities->supportsSwarm) {
    // Use the explicit generated Swarm API.
}
```

Capabilities are conservative hints, not a hardcoded compatibility matrix. Engine-specific endpoints belong in `raw()` or an explicit adapter.

See [COMPATIBILITY.md](COMPATIBILITY.md) for the supported/tested distinction, exact API range, transport coverage, and the separate stability guarantees for the stable, generated, and raw layers.

## Connections

Unix socket:

```php
$docker = DockerClient::create('unix:///var/run/docker.sock');
```

HTTP/TLS:

```php
use Misaf\DockerEngine\Transport\TlsOptions;

$docker = DockerClient::create(
    host: 'https://docker.example.test:2376',
    tls: new TlsOptions(
        ca: '/etc/docker/ca.pem',
        certificate: '/etc/docker/cert.pem',
        privateKey: '/etc/docker/key.pem',
    ),
);
```

## Architecture and dependencies

The stable resource API, generated API, raw API, mapping, streaming, engine capability, and transport layers are separate. Public operations depend on package contracts; `SymfonyTransport` is the default adapter. Standalone Symfony HttpClient, Serializer, and OptionsResolver components provide transport, typed hydration, and configuration validation. There is no Symfony Framework, Laravel, process runner, or engine CLI runtime dependency.

PHP 8.4 and Symfony 8.1 remain intentional: lowering them would broaden compatibility but is not justified by the modern SDK target. The generator's YAML, Finder, Filesystem, and Console components are development-only.

## Development

```bash
composer install
composer verify
```

Unit tests use fake transports and streams and require no daemon. Optional real-engine smoke tests are isolated:

```bash
DOCKER_SDK_INTEGRATION=1 composer test -- --group=docker-integration
```

Generated files under `src/Api`, `src/Generated`, `src/DockerClient.php`, and `src/VersionedApi.php` must be changed through the tooling:

```bash
composer docker-api:generate
composer docker-api:validate
composer docker-api:coverage
composer docker-api:determinism
```

See [CONTRIBUTING.md](CONTRIBUTING.md) for the full contributor workflow.

## License

MIT. See [LICENSE](LICENSE).
