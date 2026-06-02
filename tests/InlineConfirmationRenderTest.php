<?php

use Filament\Actions\Action;

it('renders eligible actions through the inline confirmation view', function () {
    $html = Action::make('deactivate')
        ->label('Deactivate')
        ->color('danger')
        ->requiresConfirmation()
        ->inlineConfirmation(label: 'Confirm')
        ->toHtml();

    expect($html)->toContain('x-data="inlineConfirmAction')
        ->and($html)->toContain('Confirm')
        ->and($html)->toContain('mountAction')
        ->and($html)->toContain('callMountedAction');
});

it('renders normal filament markup when inline confirmation is not eligible', function () {
    $html = Action::make('deactivate')
        ->label('Deactivate')
        ->inlineConfirmation(label: 'Confirm')
        ->toHtml();

    expect($html)->not->toContain('x-data="inlineConfirmAction')
        ->and($html)->toContain('Deactivate');
});

it('does not let the idle inline trigger fire the original livewire click handler', function () {
    $html = Action::make('deactivate')
        ->label('Deactivate')
        ->requiresConfirmation()
        ->inlineConfirmation(label: 'Confirm')
        ->toHtml();

    expect($html)->not->toContain('wire:click');
});
