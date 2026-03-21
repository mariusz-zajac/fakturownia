# Repository Guidelines

## Project Structure & Module Organization
This repository is a PHP client library for the Fakturownia API. Production code lives in `src/`, with API resources under `src/Api` and exceptions under `src/Exception`. Tests are split by scope: `tests/Unit` for isolated behavior and `tests/Functional` for integration-style API coverage. Root-level config files define the main workflow: `composer.json`, `phpunit.xml.dist`, `.php-cs-fixer.dist.php`, `Makefile`, and `Dockerfile`.

## Build, Test, and Development Commands
Run PHP/Composer commands through Docker with `make run cmd="..."` rather than assuming local `php` or `composer` binaries are installed. Install dependencies with `make run cmd="composer install"`.

- `make run cmd="composer tests"`: run the full PHPUnit suite from `tests/`.
- `make run cmd="vendor/bin/phpunit --testsuite Unit"`: run fast unit coverage only.
- `make run cmd="vendor/bin/phpunit --testsuite Functional"`: run functional tests; requires valid Fakturownia env vars.
- `make run cmd="composer php-cs"`: check code style with PHP-CS-Fixer in dry-run mode.
- `make run cmd="composer php-cs-fix"`: apply formatting fixes.
- `make build`: build the Docker image used for local development.
- `make sh`: open an interactive shell in the project Docker container.

## Coding Style & Naming Conventions
Follow PSR-4 namespaces rooted at `Abb\\Fakturownia\\` and keep one class per file. New API endpoints should usually be added as `src/Api/<Resource>.php` with matching tests in `tests/Unit/Api` and, when applicable, `tests/Functional/Api`. The codebase uses `declare(strict_types=1);`, typed properties, and Symfony-style formatting via PHP-CS-Fixer. Use 4-space indentation, PascalCase for classes, camelCase for methods and properties, and descriptive test names such as `testCreateServiceSuccessfully`. Ensure text files end with a trailing newline.

## Testing Guidelines
PHPUnit 9.6 is the test framework. Put pure logic and response-shape assertions in unit tests; reserve functional tests for real API interactions and environment-driven scenarios. Functional runs read `FAKTUROWNIA_*` values from `phpunit.xml.dist`, so do not hardcode secrets in tests. Keep coverage focused on `src/` and add or update tests with every public API change.

## Agent Workflow
Prefer the smallest useful verification step first, for example `make run cmd="vendor/bin/phpunit --testsuite Unit"` or a single test file, before running the full suite. After code changes, run the relevant tests. Use `make run cmd="composer php-cs"` to check code style and `make run cmd="composer php-cs-fix"` to apply formatting fixes when needed. For public API changes, update tests together with the implementation and add functional coverage when the change depends on real API integration rather than isolated request or response handling. Preserve compatibility with the repository's supported PHP constraints from `composer.json` when choosing syntax and language features. If requirements, expected behavior, or scope are unclear, ask the user instead of guessing.

## Commit & Pull Request Guidelines
Recent history favors short, imperative commit subjects such as `Added Products::delete method` and `Updated README`. Keep the subject line concise, capitalized, and focused on one change. Pull requests should describe the API surface affected, note any new env vars or behavior changes, and include the commands you ran (`make run cmd="composer tests"`, `make run cmd="composer php-cs"`). Add example payloads or responses when changing request/response handling.
