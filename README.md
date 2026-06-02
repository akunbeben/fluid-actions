# Inline confirmation for Filament Actions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/akunbeben/inline-confirm.svg?style=flat-square)](https://packagist.org/packages/akunbeben/inline-confirm)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/akunbeben/inline-confirm/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/akunbeben/inline-confirm/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/akunbeben/inline-confirm/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/akunbeben/inline-confirm/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/akunbeben/inline-confirm.svg?style=flat-square)](https://packagist.org/packages/akunbeben/inline-confirm)

Inline confirmation for selected Filament actions. The plugin replaces modal confirmation with a compact in-place confirmation interaction for actions that explicitly opt in.

## Installation

You can install the package via composer:

```bash
composer require akunbeben/inline-confirm
```

> [!IMPORTANT]
> If you have not set up a custom theme and are using Filament Panels follow the instructions in the [Filament Docs](https://filamentphp.com/docs/4.x/styling/overview#creating-a-custom-theme) first.

After setting up a custom theme, add the plugin's views to your theme CSS file or your app's CSS file if using the standalone packages.

```css
@source '../../../../vendor/akunbeben/inline-confirm/resources/**/*.blade.php';
```

## Usage

Register the plugin in your Filament panel:

```php
use Akunbeben\InlineConfirm\InlineConfirmPlugin;

$panel
    ->plugin(InlineConfirmPlugin::make());
```

Opt in per action:

```php
Action::make('deactivate')
    ->requiresConfirmation()
    ->inlineConfirmation();
```

Custom confirmation label and timeout:

```php
Action::make('deactivate')
    ->requiresConfirmation()
    ->inlineConfirmation(
        label: 'Confirm',
        timeout: 3000,
    );
```

Only confirmation-only, non-grouped actions are rendered inline. Actions with forms, custom modal content, URL behavior, submit behavior, or dropdown grouping fall back to Filament's default modal behavior.

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
