<?php

declare(strict_types=1);

namespace Akunbeben\FluidActions;

use Akunbeben\FluidActions\HoldToConfirm\HoldToConfirmMacros;
use Akunbeben\FluidActions\HoldToConfirm\HoldToConfirmManager;
use Akunbeben\FluidActions\InlineConfirmation\InlineConfirmationMacros;
use Akunbeben\FluidActions\InlineConfirmation\InlineConfirmationManager;
use Filament\Actions\Action;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FluidActionsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'fluid-actions';

    public static string $viewNamespace = 'fluid-actions';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command): void {
                $command
                    ->askToStarRepoOnGitHub('akunbeben/fluid-actions');
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
        $this->app->singleton(HoldToConfirmManager::class);
    }

    public function packageBooted(): void
    {
        Action::macro('inlineConfirmation', InlineConfirmationMacros::inlineConfirmation());
        Action::macro('isInlineConfirmationEligible', InlineConfirmationMacros::isInlineConfirmationEligible());

        Action::macro('holdToConfirm', HoldToConfirmMacros::holdToConfirm());
        Action::macro('isHoldToConfirmEligible', HoldToConfirmMacros::isHoldToConfirmEligible());

        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );
    }

    protected function getAssetPackageName(): ?string
    {
        return 'akunbeben/fluid-actions';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            Css::make('fluid-actions-styles', __DIR__ . '/../resources/dist/fluid-actions.css'),
            Js::make('fluid-actions-scripts', __DIR__ . '/../resources/dist/fluid-actions.js'),
        ];
    }
}
