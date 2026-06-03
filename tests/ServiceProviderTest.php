<?php

use Akunbeben\InlineConfirm\InlineConfirmation\InlineConfirmationManager;
use Akunbeben\InlineConfirm\InlineConfirmServiceProvider;
use Filament\Actions\Action;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;

it('registers the package service provider', function (): void {
    expect(app()->getProvider(InlineConfirmServiceProvider::class))
        ->toBeInstanceOf(InlineConfirmServiceProvider::class);
});

it('registers inline confirmation assets', function (): void {
    $provider = app()->getProvider(InlineConfirmServiceProvider::class);
    $method = new ReflectionMethod($provider, 'getAssets');

    $assets = $method->invoke($provider);

    expect($assets)->toHaveCount(2)
        ->and($assets[0])->toBeInstanceOf(Css::class)
        ->and($assets[0]->getId())->toBe('inline-confirm-styles')
        ->and($assets[0]->getPath())->toEndWith('/resources/dist/inline-confirm.css')
        ->and($assets[1])->toBeInstanceOf(Js::class)
        ->and($assets[1]->getId())->toBe('inline-confirm-scripts')
        ->and($assets[1]->getPath())->toEndWith('/resources/dist/inline-confirm.js');
});

it('registers InlineConfirmationManager as a singleton', function (): void {
    $first = app(InlineConfirmationManager::class);
    $second = app(InlineConfirmationManager::class);

    expect($first)->toBe($second);
});

it('registers macros on the Action class', function (): void {
    expect(Action::hasMacro('inlineConfirmation'))->toBeTrue()
        ->and(Action::hasMacro('isInlineConfirmationEligible'))->toBeTrue();
});
