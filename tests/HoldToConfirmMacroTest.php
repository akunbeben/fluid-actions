<?php

use Akunbeben\FluidActions\HoldToConfirm\HoldToConfirmManager;
use Filament\Actions\Action;

it('adds a chainable holdToConfirm macro to actions', function (): void {
    $action = Action::make('danger');

    expect($action->holdToConfirm())->toBe($action)
        ->and(app(HoldToConfirmManager::class)->for($action))->not->toBeNull();
});

it('stores hold to confirm options', function (): void {
    $action = Action::make('danger')
        ->holdToConfirm(duration: 2500, closeDropdown: false);

    $config = app(HoldToConfirmManager::class)->for($action);

    expect($config->duration)->toBe(2500)
        ->and($config->closeDropdown)->toBeFalse();
});

it('stores the original explicit view', function (): void {
    $action = Action::make('icon')
        ->view('filament::components.icon-button')
        ->holdToConfirm();

    $config = app(HoldToConfirmManager::class)->for($action);

    expect($config->originalView)->toBe('filament::components.icon-button');
});

it('uses the default duration of 1500ms', function (): void {
    $action = Action::make('default-duration')
        ->holdToConfirm();

    $config = app(HoldToConfirmManager::class)->for($action);

    expect($config->duration)->toBe(1500);
});

it('exposes an isHoldToConfirmEligible macro', function (): void {
    $eligible = Action::make('eligible')
        ->holdToConfirm();

    $ineligible = Action::make('ineligible');

    expect($eligible->isHoldToConfirmEligible())->toBeTrue()
        ->and($ineligible->isHoldToConfirmEligible())->toBeFalse();
});

it('isolates configs for multiple actions in the same request', function (): void {
    $manager = app(HoldToConfirmManager::class);

    $first = Action::make('first')->holdToConfirm(duration: 1000);
    $second = Action::make('second')->holdToConfirm(duration: 3000);

    expect($manager->for($first)->duration)->toBe(1000)
        ->and($manager->for($second)->duration)->toBe(3000);
});

it('retains configuration when the action is cloned', function (): void {
    $action = Action::make('clone-test')
        ->holdToConfirm(duration: 2500);

    $clone = $action->getClone();

    $config = app(HoldToConfirmManager::class)->for($clone);

    expect($config)->not->toBeNull()
        ->and($config->duration)->toBe(2500)
        ->and($clone->isHoldToConfirmEligible())->toBeTrue();
});
