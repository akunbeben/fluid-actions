<?php

declare(strict_types=1);

namespace Akunbeben\InlineConfirm;

use Akunbeben\InlineConfirm\InlineConfirmation\InlineConfirmationMacros;
use Akunbeben\InlineConfirm\InlineConfirmation\InlineConfirmationManager;
use Filament\Actions\Action;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InlineConfirmServiceProvider extends PackageServiceProvider
{
    public static string $name = 'inline-confirm';

    public static string $viewNamespace = 'inline-confirm';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command): void {
                $command
                    ->askToStarRepoOnGitHub('akunbeben/inline-confirm');
            });

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(InlineConfirmationManager::class);
    }

    public function packageBooted(): void
    {
        Action::macro('inlineConfirmation', InlineConfirmationMacros::inlineConfirmation());
        Action::macro('isInlineConfirmationEligible', InlineConfirmationMacros::isInlineConfirmationEligible());

        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );
    }

    protected function getAssetPackageName(): ?string
    {
        return 'akunbeben/inline-confirm';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            Css::make('inline-confirm-styles', __DIR__ . '/../resources/dist/inline-confirm.css'),
            Js::make('inline-confirm-scripts', __DIR__ . '/../resources/dist/inline-confirm.js'),
        ];
    }
}
