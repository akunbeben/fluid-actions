<?php

use Akunbeben\InlineConfirm\InlineConfirmation\InlineConfirmationManager;
use Filament\Actions\Action;

it('adds a chainable inline confirmation macro to actions', function () {
    $action = Action::make('deactivate');

    expect($action->inlineConfirmation())->toBe($action)
        ->and(app(InlineConfirmationManager::class)->for($action))->not->toBeNull();
});

it('stores inline confirmation options', function () {
    $action = Action::make('deactivate')
        ->inlineConfirmation(timeout: 1500);

    $config = app(InlineConfirmationManager::class)->for($action);

    expect($config->timeout)->toBe(1500);
});
