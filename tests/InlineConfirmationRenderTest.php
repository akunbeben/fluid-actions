<?php

use Akunbeben\InlineConfirm\InlineConfirmation\InlineConfirmationManager;
use Filament\Actions\Action;

it('renders eligible actions through the inline confirmation view', function () {
    $html = Action::make('deactivate')
        ->label('Deactivate')
        ->color('danger')
        ->requiresConfirmation()
        ->modalSubmitActionLabel('Confirm')
        ->inlineConfirmation()
        ->toHtml();

    expect($html)->toContain('x-data="inlineConfirmAction')
        ->and($html)->toContain('Confirm')
        ->and($html)->toContain('mountAction')
        ->and($html)->toContain('callMountedAction');
});

it('renders normal filament markup when inline confirmation is not eligible', function () {
    $html = Action::make('deactivate')
        ->label('Deactivate')
        ->inlineConfirmation()
        ->toHtml();

    expect($html)->not->toContain('x-data="inlineConfirmAction')
        ->and($html)->toContain('Deactivate');
});

it('does not let the idle inline trigger fire the original livewire click handler', function () {
    $html = Action::make('deactivate')
        ->label('Deactivate')
        ->requiresConfirmation()
        ->modalSubmitActionLabel('Confirm')
        ->inlineConfirmation()
        ->toHtml();

    expect($html)->not->toContain('wire:click');
});

it('renders the original action from a clone without reusing the inline view cache', function () {
    $action = Action::make('deactivate')
        ->label('Deactivate')
        ->requiresConfirmation()
        ->modalSubmitActionLabel('Confirm')
        ->inlineConfirmation();

    $action->render();

    $html = app(InlineConfirmationManager::class)->renderOriginalAction($action);

    expect($html)->toContain('Deactivate')
        ->and($html)->not->toContain('x-data="inlineConfirmAction');
});
