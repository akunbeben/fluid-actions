<?php

use Akunbeben\FluidActions\FluidActionsServiceProvider;
use Akunbeben\FluidActions\HoldToConfirm\HoldToConfirmManager;
use Akunbeben\FluidActions\InlineConfirmation\InlineConfirmationManager;
use Filament\Actions\Action;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;

it('registers the package service provider', function (): void {
    expect(app()->getProvider(FluidActionsServiceProvider::class))
        ->toBeInstanceOf(FluidActionsServiceProvider::class);
});

it('registers inline confirmation assets', function (): void {
    $provider = app()->getProvider(FluidActionsServiceProvider::class);
    $method = new ReflectionMethod($provider, 'getAssets');

    $assets = $method->invoke($provider);

    expect($assets)->toHaveCount(2)
        ->and($assets[0])->toBeInstanceOf(Css::class)
        ->and($assets[0]->getId())->toBe('fluid-actions-styles')
        ->and($assets[0]->getPath())->toEndWith('/resources/dist/fluid-actions.css')
        ->and($assets[1])->toBeInstanceOf(Js::class)
        ->and($assets[1]->getId())->toBe('fluid-actions-scripts')
        ->and($assets[1]->getPath())->toEndWith('/resources/dist/fluid-actions.js');
});

it('registers InlineConfirmationManager as a singleton', function (): void {
    $first = app(InlineConfirmationManager::class);
    $second = app(InlineConfirmationManager::class);

    expect($first)->toBe($second);
});

it('registers HoldToConfirmManager as a singleton', function (): void {
    $first = app(HoldToConfirmManager::class);
    $second = app(HoldToConfirmManager::class);

    expect($first)->toBe($second);
});

it('registers macros on the Action class', function (): void {
    expect(Action::hasMacro('inlineConfirmation'))->toBeTrue()
        ->and(Action::hasMacro('isInlineConfirmationEligible'))->toBeTrue()
        ->and(Action::hasMacro('holdToConfirm'))->toBeTrue()
        ->and(Action::hasMacro('isHoldToConfirmEligible'))->toBeTrue();
});
