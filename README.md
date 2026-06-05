# Fluid Actions for Filament

![Fluid Actions](art/banner.jpeg)

Make Filament Actions feel fluid.

Fluid Actions is a UX toolkit for Filament Actions. It provides beautiful, flexible interaction components that help you design action flows that feel more intentional, contextual, and delightful.

Actions should match the context in which they are used. Some actions need confirmation, some need hesitation, some need quick feedback, and some should stay lightweight. Fluid Actions gives you more ways to shape those interactions.

## Available interactions

- **Inline confirmation** — confirm an action directly in place
- **Hold to confirm** — require users to press and hold before executing an action
- **ActionGroup support** — works inside dropdown menus and grouped actions
- **Smart fallback** — complex actions continue using Filament's default behavior
- **Per-action configuration** — customize timeout, hold duration, and dropdown behavior

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

Use inline confirmation when an action needs explicit confirmation, but the interaction should stay lightweight and close to the action itself.

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

Use hold-to-confirm when an action should require a more deliberate gesture before it executes.

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

Fluid Actions is designed to enhance simple action interactions without breaking Filament's built-in action flows. If an action needs Filament's modal or submit behavior, it automatically falls back to the original Filament action rendering.

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
