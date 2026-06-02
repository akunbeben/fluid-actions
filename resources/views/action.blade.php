@php
    $manager = app(\Akunbeben\InlineConfirm\InlineConfirmation\InlineConfirmationManager::class);
    $eligibility = app(\Akunbeben\InlineConfirm\InlineConfirmation\InlineConfirmationEligibility::class);
    $config = $manager->for($action);
@endphp

@if (! $eligibility->isEligible($action))
    {!! $manager->renderOriginalAction($action) !!}
@else
    @php
        $mountHandler = $action->getLivewireClickHandler();
        $confirmHandler = $action->getLivewireCallMountedActionName();
        $label = $config?->label ?? $action->getModalSubmitActionLabel();
    @endphp

    <span
        x-data="inlineConfirmAction({
            timeout: @js($config?->timeout ?? 3000),
            confirm: () => Promise.resolve($wire.{{ $mountHandler }}).then(() => $wire.{{ $confirmHandler }}()),
        })"
        x-on:click.outside="disarm()"
        x-on:keydown.escape.window="disarm()"
        class="ic-action"
    >
        <span x-show="! armed" x-on:click.prevent.stop="arm()">
            {!! $manager->renderOriginalAction($action, isLivewireClickHandlerEnabled: false) !!}
        </span>

        <button
            x-cloak
            x-show="armed"
            x-on:click.prevent.stop="confirm()"
            type="button"
            class="ic-confirm"
        >
            {{ $label }}
        </button>
    </span>
@endif
