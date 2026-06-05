<?php

use Akunbeben\FluidActions\InlineConfirmation\InlineConfirmationEligibility;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\HtmlString;

it('requires both inline confirmation and requires confirmation', function (): void {
    $eligibility = app(InlineConfirmationEligibility::class);

    expect($eligibility->isEligible(Action::make('plain')->inlineConfirmation()))->toBeFalse()
        ->and($eligibility->isEligible(Action::make('confirmed')->requiresConfirmation()))->toBeFalse()
        ->and($eligibility->isEligible(Action::make('inline')->requiresConfirmation()->inlineConfirmation()))->toBeTrue();
});

it('falls back for modal content', function (): void {
    $eligibility = app(InlineConfirmationEligibility::class);

    $withContent = Action::make('content')
        ->requiresConfirmation()
        ->modalContent(new HtmlString('Important details'))
        ->inlineConfirmation();

    expect($eligibility->isEligible($withContent))->toBeFalse();
});

it('is eligible for grouped actions', function (): void {
    $eligibility = app(InlineConfirmationEligibility::class);

    $grouped = Action::make('grouped')
        ->requiresConfirmation()
        ->inlineConfirmation()
        ->group(ActionGroup::make([]));

    expect($eligibility->isEligible($grouped))->toBeTrue();
});

it('falls back for url and submit actions', function (): void {
    $eligibility = app(InlineConfirmationEligibility::class);

    expect($eligibility->isEligible(Action::make('url')->url('/users')->requiresConfirmation()->inlineConfirmation()))->toBeFalse()
        ->and($eligibility->isEligible(Action::make('submit')->submit('save')->requiresConfirmation()->inlineConfirmation()))->toBeFalse();
});

it('falls back for actions with schema', function (): void {
    $action = Action::make('with-schema')
        ->schema([
            TextInput::make('name'),
        ])
        ->requiresConfirmation()
        ->inlineConfirmation();

    expect(app(InlineConfirmationEligibility::class)->isEligible($action))->toBeFalse();
});

it('falls back for modal content footer', function (): void {
    $eligibility = app(InlineConfirmationEligibility::class);

    $withFooter = Action::make('footer')
        ->requiresConfirmation()
        ->modalContentFooter(new HtmlString('Footer details'))
        ->inlineConfirmation();

    expect($eligibility->isEligible($withFooter))->toBeFalse();
});
