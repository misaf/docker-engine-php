# Compatibility and Versioning

## Support levels

- **Supported** means the public contract is intentionally maintained and regressions are eligible for fixes.
- **Tested** means automated CI exercises the stated environment or behavior.
- **Best-effort compatible** means the SDK uses a documented compatible protocol, but the complete surface is not continuously verified.
- **Unsupported** means no compatibility commitment is made.

## Compatibility table

| Area | Status | Evidence and limits |
| --- | --- | --- |
| PHP 8.4 | Supported and tested | Full verification and Docker integration run in CI. |
| PHP 8.5 | Supported and Docker-tested | Allowed by `^8.4`; Docker integration runs in CI. The full static-analysis gate runs on PHP 8.4. |
| Docker Engine API v1.40-v1.55 | Supported | Generated coverage, pinned-spec validation, determinism checks, and representative stable-contract tests cover this range. |
| Docker Engine | Reference implementation; tested | CI uses the Docker daemon supplied by GitHub's current `ubuntu-latest` runner and records its version. This is continuous current-version coverage, not a promise for every Docker release. |
| Podman Docker-compatible API | Best-effort compatible and smoke-tested | CI installs the Podman package available on `ubuntu-latest`, records its version, and runs the shared integration suite through a Unix Docker-compatible API socket. Docker-only features such as Swarm are not claimed. |
| Unix sockets | Supported and tested | Docker and Podman integration jobs use Unix sockets. |
| HTTP and HTTPS/TLS | Supported | The Symfony HttpClient transport supports both; configuration and transport behavior are unit-tested. Live remote TLS is not continuously tested. |
| Docker or Podman CLI as an SDK transport | Unsupported | Runtime operations communicate only through the Engine HTTP API. |

CI identifies tested daemon versions at run time because GitHub-hosted runner and distribution package versions change. Consult the CI run for the exact Docker and Podman versions tested for a commit.

## Versioning policy

The project follows Semantic Versioning, with stability defined per API layer.

### Stable SDK API

The contracts, resources, DTOs, value objects, enums, exceptions, and behavior reached through `containers()`, `images()`, `networks()`, `volumes()`, `exec()`, `system()`, and `capabilities()` are public API. Removing or incompatibly changing them requires a major release. Additive operations and optional capabilities may be introduced in a minor release.

### Exact generated/versioned API

`versioned()->api()` deliberately exposes types generated from pinned Docker OpenAPI schemas. Regeneration may add endpoints, schemas, or fields in a minor release. An incompatible change to an already shipped generated type is documented prominently; if it is not required to correct the pinned upstream schema, it is treated as a public API break. Consumers should pin an `ApiVersion` whenever they import a generated namespace.

### Raw API

`raw()` and the transport contracts are public SDK APIs, but endpoint paths, payloads, status codes, and streaming behavior ultimately follow the connected Engine implementation and negotiated API version. The SDK preserves transport and normalized exception guarantees; it cannot make arbitrary raw endpoint semantics version-independent.

## Capability policy

Capabilities are conservative behavioral hints derived from negotiation, `/version`, and `/info`. An unknown engine is not assumed to support an optional feature. Capabilities do not replace handling a normalized API error when a daemon advertises incomplete or incompatible behavior.
