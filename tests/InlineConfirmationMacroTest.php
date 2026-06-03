<?php

use Akunbeben\InlineConfirm\InlineConfirmation\InlineConfirmationManager;
use Filament\Actions\Action;

it('adds a chainable inline confirmation macro to actions', function (): void {
    $action = Action::make('deactivate');

    expect($action->inlineConfirmation())->toBe($action)
        ->and(app(InlineConfirmationManager::class)->for($action))->not->toBeNull();
});

it('stores inline confirmation options', function (): void {
    $action = Action::make('deactivate')
        ->inlineConfirmation(timeout: 1500);

    $config = app(InlineConfirmationManager::class)->for($action);

    expect($config->timeout)->toBe(1500);
});

it('uses the default timeout of 3000ms', function (): void {
    $action = Action::make('default-timeout')
        ->inlineConfirmation();

    $config = app(InlineConfirmationManager::class)->for($action);

    expect($config->timeout)->toBe(3000);
});

it('exposes an isInlineConfirmationEligible macro', function (): void {
    $eligible = Action::make('eligible')
        ->requiresConfirmation()
        ->inlineConfirmation();

    $ineligible = Action::make('ineligible')
        ->inlineConfirmation();

    expect($eligible->isInlineConfirmationEligible())->toBeTrue()
        ->and($ineligible->isInlineConfirmationEligible())->toBeFalse();
});

it('isolates configs for multiple actions in the same request', function (): void {
    $manager = app(InlineConfirmationManager::class);

    $first = Action::make('first')->inlineConfirmation(timeout: 1000);
    $second = Action::make('second')->inlineConfirmation(timeout: 5000);

    expect($manager->for($first)->timeout)->toBe(1000)
        ->and($manager->for($second)->timeout)->toBe(5000);
});
