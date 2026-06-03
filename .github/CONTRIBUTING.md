# Contributing

Contributions are welcome. This package aims to provide a small, high-quality FilamentPHP plugin with careful UX and seamless DX, so changes should stay focused and well tested.

## Before Opening An Issue

Please check existing issues and pull requests first.

For bugs, include:

- Filament version.
- Livewire version.
- Laravel and PHP versions.
- Whether the action is a table row action, header/page action, bulk action, or another action type.
- Whether the action uses `requiresConfirmation()` and `inlineConfirmation()`.
- Whether the action has a schema/form, custom modal content, custom modal footer content, URL behavior, or submit behavior.
- A minimal action definition that reproduces the problem.

For feature requests, explain the user workflow and why the current fallback behavior is not enough. Support for richer inline copy is a roadmap item, so proposals in those areas should include expected UX details.

## Pull Requests

Keep pull requests small and focused. One behavior change per pull request is easiest to review.

Before submitting:

- Add or update tests for changed behavior.
- Update `README.md` when public API, setup, fallback behavior, or user-facing DX changes.
- Keep `inlineConfirmation()` opt-in and preserve `requiresConfirmation()` as the semantic confirmation gate.
- Preserve safe fallback to Filament's default modal behavior for unsupported action types.

## Local Checks

Run these before opening a pull request:

```bash
composer test
composer test:lint
composer analyse
npm run build
```

Use Laravel Pint for code style:

```bash
composer lint
```

## Compatibility

Avoid breaking public API without a clear versioning reason. This package follows SemVer once released.

The v1 scope is confirmation-only actions. If your change expands that scope, include tests and documentation for the new supported action type.
