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

### Configuration from environment

`DockerClient::fromEnv()` builds a client from environment variables, optionally loading a `.env` file via `symfony/dotenv` (a runtime dependency). The default `DockerClient::create()` auto-loads a `.env` from the working directory using the same cascade Symfony uses — `.env`, `.env.local`, `.env.{APP_ENV}`, `.env.{APP_ENV}.local` (Laravel-style too) — so `DOCKER_*` variables are used automatically as fallbacks. Process environment variables always take precedence, and any explicit argument to `create()` overrides the environment.

```php
use Misaf\DockerEngine\DockerClient;

// Loads ./env when present, then reads DOCKER_HOST and friends.
$docker = DockerClient::fromEnv();

// Or point at an explicit file.
$docker = DockerClient::fromEnv('/srv/app/.env');
```

Recognised variables:

| Variable | Description | Default |
| --- | --- | --- |
| `DOCKER_HOST` | Engine host (`unix://`, `tcp://`, `http://`, `https://`). | `unix:///var/run/docker.sock` |
| `DOCKER_API_VERSION` | Pin the Engine API version, e.g. `1.55`. | negotiate |
| `DOCKER_TIMEOUT_CONNECT` | Connection timeout (seconds, float). | `5.0` |
| `DOCKER_TIMEOUT_REQUEST` | Request timeout (seconds, float). | `60.0` |
| `DOCKER_TLS_CA` | Path to the TLS CA certificate file. | _none_ |
| `DOCKER_TLS_CERT` | Path to the TLS client certificate file. | _none_ |
| `DOCKER_TLS_KEY` | Path to the TLS client private key file. | _none_ |
| `DOCKER_TLS_KEY_PASSWORD` | Password for the TLS private key. | _none_ |
| `DOCKER_TLS_VERIFY_PEER` | Verify the peer certificate (`true`/`false`). | `true` |
| `DOCKER_TLS_VERIFY_HOST` | Verify the peer host name (`true`/`false`). | `true` |

TLS is only enabled when at least one of `DOCKER_TLS_CA`, `DOCKER_TLS_CERT`, or `DOCKER_TLS_KEY` is set.

## Symfony integration

The package ships a Symfony bundle and a `symfony/config` definition tree, so it drops into a Symfony application as a normal service. Add `misaf/docker-engine-php` and register the bundle in `config/bundles.php`:

```php
return [
    // ...
    Misaf\DockerEngine\DockerEngineBundle::class => ['all' => true],
];
```

Configure it in `config/packages/docker_engine.yaml` (config keys mirror `ClientOptions`, and values may use `%env(DOCKER_HOST)%` placeholders):

```yaml
docker_engine:
    host: '%env(DOCKER_HOST)%'
    api_version: '1.55'
    timeouts:
        connect: 5.0
        request: 60.0
    tls:
        ca: '%env(DOCKER_TLS_CA)%'
        certificate: '%env(DOCKER_TLS_CERT)%'
        private_key: '%env(DOCKER_TLS_KEY)%'
        verify_peer: true
        verify_host: true
    headers:
        X-Custom: 'value'
```

The `DockerClient` is then available from the container and autowirable:

```php
use Misaf\DockerEngine\DockerClient;

public function index(DockerClient $docker): Response
{
    $docker->containers()->list();

    // ...
}
```

Outside a bundle, the same tree is reusable directly:

```php
use Misaf\DockerEngine\DockerClient;

$config = DockerClient::processConfig(require 'docker_engine.php'); // validates + applies defaults
$client = DockerClient::fromArray($config);
```

The tree is defined in `Misaf\DockerEngine\DependencyInjection\Configuration` and the wiring in `Misaf\DockerEngine\DependencyInjection\DockerEngineExtension`.

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

## Command-line interface

The package ships a `docker-engine` binary (requires `symfony/console`, already a runtime dependency). After `composer require misaf/docker-engine-php` it is installed into your project's `vendor/bin`.

```bash
vendor/bin/docker-engine ping
vendor/bin/docker-engine ps -a
vendor/bin/docker-engine images
vendor/bin/docker-engine version
vendor/bin/docker-engine info
```

Every command accepts connection options:

| Option | Description | Default |
| --- | --- | --- |
| `--host` | Engine host (`unix://`, `tcp://`, `http://`, `https://`). | `unix:///var/run/docker.sock` |
| `--api-version` | Pin the Engine API version, e.g. `1.55`. | negotiate |
| `--tls-ca` | Path to the TLS CA certificate file. | _none_ |
| `--tls-cert` | Path to the TLS client certificate file. | _none_ |
| `--tls-key` | Path to the TLS client private key file. | _none_ |
| `--tls-verify-peer` / `--no-tls-verify-peer` | Verify the peer certificate. | enabled |
| `--tls-verify-host` / `--no-tls-verify-host` | Verify the peer host name. | enabled |

`ps` and `images` also accept `-a`/`--all` and `--format=json` (default `table`):

```bash
vendor/bin/docker-engine ps -a --format=json
```

The CLI is built on the same `DockerClient` and `raw()` API used in the library, so it works against any negotiated Engine version without invoking the Docker CLI.

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

Symfony YAML, Finder, and Filesystem are development-only dependencies used by the committed OpenAPI generator. Symfony Console is a runtime dependency that powers the `docker-engine` CLI, Symfony Dotenv backs the `DockerClient::fromEnv()` environment loader, and Symfony Config plus DependencyInjection back the optional `DockerEngineBundle`. The core SDK stays framework-neutral: the bundle and config tree are an opt-in integration layer.

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

See [CONTRIBUTING.md](CONTRIBUTING.md) for the full contributor workflow, including how to work with and regenerate the OpenAPI-derived code.

## Framework compatibility

The SDK has no Laravel, Illuminate, or Symfony Framework dependency. Plain PHP, Laravel, Symfony applications, CLI programs, and other frameworks all consume the same `DockerClient` implementation.

## License

MIT. See [LICENSE](LICENSE).
