# Fluid Actions for Filament

![Fluid Actions](art/banner.jpeg)

Fluid Actions adds compact, in-place confirmation interactions to Filament actions. It helps you avoid confirmation modals for simple, destructive, or high-friction actions while still requiring explicit user intent.

## Features

- Inline confirmation for actions that already use `requiresConfirmation()`
- Hold-to-confirm actions without opening a modal
- Support for actions inside `ActionGroup` dropdowns and button groups
- Automatic fallback to Filament's default behavior for complex actions
- Per-action configuration for timeout, hold duration, and dropdown closing behavior

## Installation

Install the package via Composer:

```bash
composer require akunbeben/fluid-actions
```

Register the plugin in your Filament panel:

```php
use Akunbeben\FluidActions\FluidActionsPlugin;

$panel
    ->plugin(FluidActionsPlugin::make());
```

## Inline confirmation

Use inline confirmation when you still want Filament's confirmation semantics, but want the confirmation to appear directly in place instead of inside a modal.

```php
use Filament\Actions\Action;

Action::make('deactivate')
    ->color('danger')
    ->requiresConfirmation()
    ->inlineConfirmation();
```

> `inlineConfirmation()` does not call `requiresConfirmation()` for you. You must explicitly use both methods.

### Custom label and timeout

The inline confirmation button uses Filament's modal submit action label.

```php
Action::make('deactivate')
    ->color('danger')
    ->requiresConfirmation()
    ->modalSubmitActionLabel('Confirm')
    ->inlineConfirmation(timeout: 3000);
```

The timeout is in milliseconds. The default is `3000`.

## Hold to confirm

Use hold-to-confirm when you want the user to press and hold the action before it executes.

```php
use Filament\Actions\Action;

Action::make('delete')
    ->color('danger')
    ->holdToConfirm();
```

By default, the user must hold the action for `1500` milliseconds.

```php
Action::make('delete')
    ->color('danger')
    ->holdToConfirm(duration: 3000);
```

Unlike inline confirmation, `holdToConfirm()` does not require `requiresConfirmation()`.

## Actions inside groups

Fluid Actions supports actions inside dropdowns and button groups.

```php
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;

ActionGroup::make([
    Action::make('edit')
        ->label('Edit'),

    Action::make('delete')
        ->label('Delete')
        ->color('danger')
        ->requiresConfirmation()
        ->inlineConfirmation(),
]);
```

When an inline confirmation action is triggered inside a dropdown, the dropdown stays open so the confirmation state can be shown. After confirmation, the action executes and the dropdown closes.

## Dropdown closing behavior

You can control whether a grouped action closes its dropdown after confirmation.

```php
Action::make('delete')
    ->requiresConfirmation()
    ->inlineConfirmation(closeDropdown: false);
```

You may also pass a closure:

```php
Action::make('delete')
    ->requiresConfirmation()
    ->inlineConfirmation(
        closeDropdown: fn (): bool => auth()->user()->prefers_compact_actions,
    );
```

The same option is available for hold-to-confirm:

```php
Action::make('delete')
    ->holdToConfirm(closeDropdown: false);
```

## Eligibility and fallback behavior

Fluid Actions only renders simple action confirmations inline. If an action needs Filament's modal or submit behavior, it automatically falls back to the original Filament action rendering.

Actions fall back when they have:

- forms or schemas
- custom modal content
- custom modal footer content
- URL behavior
- POST-to-URL behavior
- form submit behavior

For inline confirmation, the action must also use `requiresConfirmation()`.

## Testing

```bash
composer test
```

Run static analysis:

```bash
composer analyse
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Benny Rahmat](https://github.com/akunbeben)
- [All Contributors](https://github.com/akunbeben/fluid-actions/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
