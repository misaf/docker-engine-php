# Docker Engine PHP

A framework-neutral PHP 8.4 SDK for Docker Engine API v1.40 through v1.55. It talks directly to the Engine API over Unix sockets or HTTP/TLS and never invokes the Docker CLI.

## Installation

```bash
composer require misaf/docker-engine-php
```

## Quick start

```php
<?php

use Misaf\DockerEngine\DockerClient;

$docker = DockerClient::create(
    host: 'unix:///var/run/docker.sock',
);

$containers = $docker->containers()->list();
```

The client negotiates the newest mutually supported API version. Pin a version when reproducible request and response shapes are more important:

```php
use Misaf\DockerEngine\ApiVersion;
use Misaf\DockerEngine\DockerClient;

$docker = DockerClient::create(
    host: 'http://docker.example.test:2375',
    version: ApiVersion::V1_55,
);
```

For a TLS-protected remote daemon:

```php
use Misaf\DockerEngine\DockerClient;
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

## Typed APIs

Every supported version has distinct request, response, and schema classes under `Misaf\DockerEngine\Api\V1_40` through `V1_55`. The public client exposes Container, Image, Network, Volume, Exec, System, Swarm, Node, Service, Task, Secret, Config, Plugin, Distribution, and Session groups where the selected Engine version provides them.

```php
use Misaf\DockerEngine\Api\V1_55\Container\Requests\ContainerCreateRequest;
use Misaf\DockerEngine\Api\V1_55\Schemas\ContainerConfig;

$created = $docker->containers()->create(new ContainerCreateRequest(
    body: new ContainerConfig(image: 'nginx:latest'),
    name: 'web',
));

$docker->containers()->start($created->id);
```

Serialization preserves the distinction between an absent field and explicit `null`, `false`, `0`, an empty array, or an empty string. Generated DTOs remain version-specific rather than being flattened into a universal model.

## Streaming and exec

Streaming responses are lazy. The SDK owns Docker-specific multiplex framing, TTY raw streams, JSON-line progress, WebSocket upgrade handling, and socket hijacking.

```php
$logs = $docker->containers()->logs('web');

foreach ($logs->frames() as $frame) {
    echo $frame->payload;
}

$result = $docker->exec()->run(
    container: 'web',
    command: ['php', '-v'],
);
```

Exec and all other Docker operations use the Engine API; `docker`, `symfony/process`, and shell execution are not runtime dependencies.

## Raw access

Use the version-aware raw API for daemon extensions or endpoints newer than the generated surface:

```php
$response = $docker->raw()->request('GET', '/info');
$payload = $response->json();
```

## Architecture

The public API depends on the package's `Transport` contract. `SymfonyTransport` is the default implementation and uses standalone Symfony HttpClient. Symfony Serializer handles typed hydration through a Docker-aware normalizer, and OptionsResolver validates array-shaped configuration before it becomes typed options. No Symfony Framework bundle, kernel, dependency-injection container, or runtime is used.

Symfony Console, YAML, Finder, and Filesystem are development-only dependencies used by the committed OpenAPI generator:

```bash
php tools/docker-api docker-api:generate --all
php tools/docker-api docker-api:validate
php tools/docker-api docker-api:coverage
php tools/docker-api docker-api:determinism
```

## Development

```bash
composer install
composer verify
```

Unit tests use fake transports and require no daemon. The optional integration smoke test is isolated:

```bash
DOCKER_SDK_INTEGRATION=1 composer test -- --group=docker-integration
```

## Framework compatibility

The SDK has no Laravel, Illuminate, or Symfony Framework dependency. Plain PHP, Laravel, Symfony applications, CLI programs, and other frameworks all consume the same `DockerClient` implementation.

## License

MIT. See [LICENSE](LICENSE).
