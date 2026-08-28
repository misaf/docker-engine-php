# AGENTS.md

PHP 8.4 library (PSR-4 `Misaf\DockerEngine\` → `src/`). A framework-neutral Docker Engine API SDK. It talks to the daemon over Unix socket / HTTP / TLS and **never** invokes the Docker CLI or shell; `symfony/process` is intentionally not a runtime dependency.

## Commands

- `composer install` — install deps.
- `composer verify` — full gate: format-check → phpstan → test → spec validate → coverage → determinism. Run this before considering work done.
- `composer test` — Pest suite (`vendor/bin/pest`). Needs `-d memory_limit=1G` (already set in the script).
- `composer analyse` — PHPStan level 10, **src only** (phpstan.neon excludes tests/tools).
- `composer format` / `composer format-check` — canonical formatter is **php-cs-fixer** with risky rules allowed (`@PER-CS2.0` + strict types + ordered imports). The `pint.json` file exists but is not wired into composer scripts; do not use Pint as the formatter.
- Integration smoke test (needs a live Docker daemon):

  ```bash
  DOCKER_SDK_INTEGRATION=1 composer test -- --group=docker-integration
  ```

  Unit tests use `tests/Support/FakeDockerTransport` and require no daemon.

## Code generation (high-signal)

The `src/Api/*` classes, `src/Generated/*`, and `src/DockerClient.php` are **committed, generated code** — do not hand-edit them.

- Regenerate from the Moby OpenAPI specs in `tools/specs/*.yaml`:

  ```bash
  php tools/docker-api docker-api:generate --all
  ```

  This also runs `composer format` automatically.
- Validate spec coverage / regen determinism (part of `composer verify`):

  ```bash
  php tools/docker-api docker-api:validate
  php tools/docker-api docker-api:coverage
  php tools/docker-api docker-api:determinism
  ```
- `tools/specs` are dev inputs pinned to a specific moby commit (see `tools/specs/README.md`). Updating a spec requires refreshing `tools/specs/checksums.sha256` and reviewing the Moby changelog.

## Architecture notes

- Public API depends on the `Transport` contract; `SymfonyTransport` (standalone Symfony HttpClient, no framework bundle/kernel/DI) is the default.
- Each Engine version has version-specific request/response/schema DTOs under `src/Api/V1_40` … `V1_55`; serialization preserves absent-vs-explicit-null distinctions. Negotiation picks the newest mutually supported version (pin via `ApiVersion`).
- Entrypoint is `src/DockerClient.php`; per-domain groups (containers, exec, raw, etc.) and the version-aware `raw()` API live there.
