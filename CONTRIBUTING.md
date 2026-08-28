# Contributing

Thanks for your interest in `docker-engine-php`. This document explains how the repository is structured and how to work with the generated code.

## Repository layout

| Path | Purpose |
| --- | --- |
| `src/` | Runtime library code (PSR-4 `Misaf\DockerEngine\`). |
| `src/Api/` | **Committed, generated** code: versioned DTOs (`V1_40`..`V1_55`), domain APIs, schemas. Do not hand-edit. |
| `src/Generated/` | Runtime base classes the generated code builds on. |
| `src/Contracts/` | The three interfaces the SDK depends on: `Transport`, `Serializer`, `Stream`. |
| `tools/` | Development-only OpenAPI generator and its Console commands (**not** shipped at runtime). |
| `tools/specs/` | Pinned Moby Swagger 2.0 specs (development inputs). |
| `tests/` | Pest test suite (unit + optional daemon integration). |
| `bin/` | The `docker-engine` CLI entry point. |

The `src/Api/*`, `src/Generated/*`, and `src/DockerClient.php` files are generated. Regenerate them from the pinned specs — never edit them by hand.

## Environment

- PHP 8.4+
- Composer

Install and verify everything:

```bash
composer install
composer verify
```

`composer verify` is the full gate: format-check → PHPStan → tests → spec validate → coverage → determinism. Run it before considering work done.

## Commands

| Command | Description |
| --- | --- |
| `composer verify` | Full gate, run before finishing. |
| `composer analyse` | PHPStan level 10, `src/` only. |
| `composer test` | Pest suite (no daemon required). |
| `composer format` / `composer format-check` | Code style via **Pint** (PER preset, strict types, ordered imports). |
| `composer docker-api:generate --all` | Regenerate all versioned APIs + client, then format. |

Note: Pint (`pint.json`) is the canonical formatter — do not use php-cs-fixer.

## Working with the generated code

The generator consumes the Swagger 2.0 specs pinned in `tools/specs/`, which are tracked to a specific Moby commit (see `tools/specs/README.md`).

To regenerate after changing a spec or the generator:

```bash
php tools/docker-api docker-api:generate --all
```

This rewrites `src/Api/*`, `src/Generated/*`, and `src/DockerClient.php`, then runs the formatter.

Validate the result:

```bash
php tools/docker-api docker-api:validate
php tools/docker-api docker-api:coverage
php tools/docker-api docker-api:determinism
```

These checks are also part of `composer verify`.

### Updating a spec

1. Read `tools/specs/README.md` and review the Moby Engine API changelog for the new commit.
2. Replace the `.yaml` file(s) and refresh `tools/specs/checksums.sha256` (`shasum -a 256 tools/specs/v1.XX.yaml`).
3. Regenerate and run the coverage and determinism checks.
4. Run the full `composer verify`.

## Testing

Unit tests run against `tests/Support/FakeDockerTransport` and require no daemon:

```bash
composer test
```

The optional integration smoke test hits a real daemon and is isolated:

```bash
DOCKER_SDK_INTEGRATION=1 composer test -- --group=docker-integration
```

## Code style

- `Pint` (PER preset) with strict types and ordered imports.
- Run `composer format` before committing.

## Pull requests

- Keep generated code in sync with the specs (see above).
- Run `composer verify` and make sure it passes.
- Match the existing commit message style.

## License

MIT. See [LICENSE](LICENSE).
