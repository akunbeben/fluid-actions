<?php

use Akunbeben\InlineConfirm\HoldToConfirm\HoldToConfirmManager;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;

it('renders eligible actions through the hold to confirm view', function (): void {
    $html = Action::make('danger')
        ->label('Delete')
        ->color('danger')
        ->holdToConfirm()
        ->toHtml();

    expect($html)->toContain('x-data="holdToConfirmAction')
        ->and($html)->toContain('htc-trigger')
        ->and($html)->toContain('mountAction')
        ->and($html)->toContain('callMountedAction');
});

it('renders normal filament markup when hold to confirm is not eligible', function (): void {
    $html = Action::make('url-action')
        ->label('Visit')
        ->url('/somewhere')
        ->holdToConfirm()
        ->toHtml();

    expect($html)->not->toContain('x-data="holdToConfirmAction')
        ->and($html)->toContain('Visit');
});

it('does not let the hold trigger fire the original livewire click handler', function (): void {
    $html = Action::make('danger')
        ->label('Delete')
        ->holdToConfirm()
        ->toHtml();

    expect($html)->not->toContain('wire:click');
});

it('renders the original action from a clone without reusing the hold view cache', function (): void {
    $action = Action::make('danger')
        ->label('Delete')
        ->holdToConfirm();

    $action->render();

    $html = app(HoldToConfirmManager::class)->renderOriginalAction($action);

    expect($html)->toContain('Delete')
        ->and($html)->not->toContain('x-data="holdToConfirmAction');
});

it('renders grouped actions through the hold to confirm view', function (): void {
    $action = Action::make('delete')
        ->label('Delete')
        ->color('danger')
        ->holdToConfirm();

    $action->group(ActionGroup::make([]));

    $html = $action->toHtml();

    expect($html)->toContain('x-data="holdToConfirmAction')
        ->and($html)->toContain('isGrouped: true');
});

it('renders the custom duration value in the output', function (): void {
    $html = Action::make('slow')
        ->label('Slow')
        ->holdToConfirm(duration: 3000)
        ->toHtml();

    expect($html)->toContain('duration: 3000')
        ->and($html)->toContain('--htc-duration: 3000ms');
});

it('preserves an explicit custom view set before holdToConfirm', function (): void {
    $action = Action::make('custom-view')
        ->label('Custom')
        ->view('filament::components.icon-button')
        ->holdToConfirm();

    $action->render();

    $html = app(HoldToConfirmManager::class)->renderOriginalAction($action);

    expect($html)->not->toContain('x-data="holdToConfirmAction');
});
