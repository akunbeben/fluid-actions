<?php

use Akunbeben\InlineConfirm\InlineConfirmation\InlineConfirmationManager;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;

it('renders eligible actions through the inline confirmation view', function (): void {
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

it('renders normal filament markup when inline confirmation is not eligible', function (): void {
    $html = Action::make('deactivate')
        ->label('Deactivate')
        ->inlineConfirmation()
        ->toHtml();

    expect($html)->not->toContain('x-data="inlineConfirmAction')
        ->and($html)->toContain('Deactivate');
});

it('does not let the idle inline trigger fire the original livewire click handler', function (): void {
    $html = Action::make('deactivate')
        ->label('Deactivate')
        ->requiresConfirmation()
        ->modalSubmitActionLabel('Confirm')
        ->inlineConfirmation()
        ->toHtml();

    expect($html)->not->toContain('wire:click');
});

it('renders the original action from a clone without reusing the inline view cache', function (): void {
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

it('renders grouped actions through the inline confirmation view', function (): void {
    $action = Action::make('delete')
        ->label('Delete')
        ->color('danger')
        ->requiresConfirmation()
        ->modalSubmitActionLabel('Confirm')
        ->inlineConfirmation();

    $action->group(ActionGroup::make([]));

    $html = $action->toHtml();

    expect($html)->toContain('x-data="inlineConfirmAction')
        ->and($html)->toContain('Confirm')
        ->and($html)->toContain('isGrouped: true');
});

it('renders the custom timeout value in the output', function (): void {
    $html = Action::make('slow')
        ->label('Slow')
        ->requiresConfirmation()
        ->inlineConfirmation(timeout: 5000)
        ->toHtml();

    expect($html)->toContain('timeout: 5000')
        ->and($html)->toContain('--ic-timeout: 5000ms');
});

it('preserves an explicit custom view set before inlineConfirmation', function (): void {
    $action = Action::make('custom-view')
        ->label('Custom')
        ->view('filament::components.icon-button')
        ->requiresConfirmation()
        ->inlineConfirmation();

    $action->render();

    $html = app(InlineConfirmationManager::class)->renderOriginalAction($action);

    expect($html)->not->toContain('x-data="inlineConfirmAction');
});
