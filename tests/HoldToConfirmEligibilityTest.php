<?php

use Akunbeben\FluidActions\HoldToConfirm\HoldToConfirmEligibility;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\HtmlString;

it('is eligible when holdToConfirm is called without requiresConfirmation', function (): void {
    $eligibility = app(HoldToConfirmEligibility::class);

    $action = Action::make('danger')
        ->holdToConfirm();

    expect($eligibility->isEligible($action))->toBeTrue();
});

it('is not eligible without holdToConfirm', function (): void {
    $eligibility = app(HoldToConfirmEligibility::class);

    expect($eligibility->isEligible(Action::make('plain')))->toBeFalse();
});

it('falls back for modal content', function (): void {
    $eligibility = app(HoldToConfirmEligibility::class);

    $withContent = Action::make('content')
        ->modalContent(new HtmlString('Important details'))
        ->holdToConfirm();

    expect($eligibility->isEligible($withContent))->toBeFalse();
});

it('is eligible for grouped actions', function (): void {
    $eligibility = app(HoldToConfirmEligibility::class);

    $grouped = Action::make('grouped')
        ->holdToConfirm()
        ->group(ActionGroup::make([]));

    expect($eligibility->isEligible($grouped))->toBeTrue();
});

it('falls back for url and submit actions', function (): void {
    $eligibility = app(HoldToConfirmEligibility::class);

    expect($eligibility->isEligible(Action::make('url')->url('/users')->holdToConfirm()))->toBeFalse()
        ->and($eligibility->isEligible(Action::make('submit')->submit('save')->holdToConfirm()))->toBeFalse();
});

it('falls back for actions with schema', function (): void {
    $action = Action::make('with-schema')
        ->schema([
            TextInput::make('name'),
        ])
        ->holdToConfirm();

    expect(app(HoldToConfirmEligibility::class)->isEligible($action))->toBeFalse();
});

it('falls back for modal content footer', function (): void {
    $eligibility = app(HoldToConfirmEligibility::class);

    $withFooter = Action::make('footer')
        ->modalContentFooter(new HtmlString('Footer details'))
        ->holdToConfirm();

    expect($eligibility->isEligible($withFooter))->toBeFalse();
});
