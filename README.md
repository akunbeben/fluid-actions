# Inline confirmation for Filament Actions

Inline confirmation for selected Filament actions. The plugin replaces modal confirmation with a compact in-place confirmation interaction for actions that explicitly opt in.

## Installation

You can install the package via composer:

```bash
composer require akunbeben/inline-confirm
```

Register the plugin in your Filament panel:

```php
use Akunbeben\InlineConfirm\InlineConfirmPlugin;

$panel
    ->plugin(InlineConfirmPlugin::make());
```

## Usage

Opt in per action:

```php
use Filament\Actions\Action;

Action::make('deactivate')
    ->requiresConfirmation()
    ->inlineConfirmation();
```

`inlineConfirmation()` only changes how confirmation is presented. It does not imply `requiresConfirmation()`, so both methods are required.

Custom confirmation label and timeout:

```php
use Filament\Actions\Action;

Action::make('deactivate')
    ->requiresConfirmation()
    ->inlineConfirmation(
        label: 'Confirm',
        timeout: 3000,
    );
```

## Limitations

Only confirmation-only, non-grouped actions are rendered inline in v1. Actions with forms, schemas, custom modal content, custom modal footer content, URL behavior, submit behavior, or dropdown grouping fall back to Filament's default modal behavior.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Benny Rahmat](https://github.com/akunbeben)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
