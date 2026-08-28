# Repository Guidelines

## Project Structure & Module Organization

Runtime code lives in `src/` under the `Misaf\DockerEngine\` PSR-4 namespace. Transport, serialization, streaming, exception, and value-object concerns have dedicated subdirectories. Tests live in `tests/Unit`, `tests/Integration`, and `tests/Support`; unit tests use `FakeDockerTransport` and do not require Docker. Development tooling and pinned Moby OpenAPI specifications live in `tools/` and `tools/specs/`.

Do not hand-edit `src/Api/*`, `src/Generated/*`, or `src/DockerClient.php`; these are committed generated files. Regenerate them with:

```bash
php tools/docker-api docker-api:generate --all
```

## Build, Test, and Development Commands

- `composer install` installs PHP dependencies.
- `composer test` runs the Pest test suite with the required memory limit.
- `composer analyse` runs PHPStan at level 10 against `src/`.
- `composer format` fixes style with Pint; `composer format-check` checks without modifying files.
- `composer verify` runs the complete quality gate: formatting, analysis, tests, spec validation, coverage, and generation determinism.
- `DOCKER_SDK_INTEGRATION=1 composer test -- --group=docker-integration` runs daemon-backed smoke tests.

## Coding Style & Naming Conventions

Target PHP 8.4 and declare strict types. Follow PER formatting, four-space indentation, alphabetically ordered imports, and the rules in `pint.json`. Use PascalCase for classes and enums, camelCase for methods and properties, and names that describe Docker concepts precisely, such as `ContainerId` or `TimeoutOptions`. Keep the SDK framework-neutral: runtime code must communicate through the `Transport` contract and must not invoke Docker CLI or shell commands.

## Testing Guidelines

Write Pest tests alongside the matching area under `tests/Unit`; reserve `tests/Integration` for tests requiring a live daemon. Name test files after the subject, using the `*Test.php` suffix. Cover success, validation, error mapping, and absent-versus-null serialization behavior. Run `composer test` during development and `composer verify` before submitting changes.

## Commit & Pull Request Guidelines

Follow the repository's concise Conventional Commit style, for example `feat: add container wait support` or `chore: refresh pinned specs`. Keep commits focused. Pull requests should explain the behavior change, note generated-file or spec updates, link related issues, and report verification performed. Screenshots are generally unnecessary for this library. Never commit secrets, daemon certificates, socket paths, or machine-specific configuration.
