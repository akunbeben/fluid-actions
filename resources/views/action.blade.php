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

        $viewComponent = match($action->getView()) {
            'filament::components.badge' => 'filament::badge',
            'filament::components.dropdown.list.item' => 'filament::dropdown.list.item',
            'filament::components.icon-button' => 'filament::icon-button',
            'filament::components.link' => 'filament::link',
            default => 'filament::button',
        };

        $icon = $action->getIcon();

        if (blank($icon)) {
            if ($viewComponent === 'filament::dropdown.list.item' && method_exists($action, 'getGroupedIcon')) {
                $icon = $action->getGroupedIcon();
            } elseif (method_exists($action, 'getTable') && $action->getTable() && method_exists($action, 'getTableIcon')) {
                $icon = $action->getTableIcon();
            }
        }
    @endphp

    <span
        x-data="inlineConfirmAction({
            timeout: @js($config?->timeout ?? 3000),
        })"
        x-on:click.outside="disarm()"
        x-on:keydown.escape.window="disarm()"
        class="ic-action"
        style="--ic-timeout: {{ $config?->timeout ?? 3000 }}ms"
    >
        <span
            class="ic-trigger"
            x-bind:class="{ 'is-hidden': armed || processing }"
            x-on:click.prevent.stop="arm()"
        >
            {!! $manager->renderOriginalAction($action, isLivewireClickHandlerEnabled: false) !!}
        </span>

        <x-dynamic-component
            :component="$viewComponent"
            class="ic-confirm"
            :color="$action->getColor() ?? 'danger'"
            :size="$action->getSize() ?? 'md'"
            :icon="$icon"
            :tooltip="$viewComponent === 'filament::icon-button' ? $action->getModalSubmitActionLabel() : null"
            x-bind:class="{ 'is-visible': armed && !processing, 'is-processing': processing }"
            x-on:click.prevent.stop="process(); Promise.resolve($wire.{!! $mountHandler !!}).then(() => $wire.{!! $confirmHandler !!}()).finally(() => disarm())"
            type="button"
        >
            @if ($viewComponent !== 'filament::icon-button')
                {{ $action->getModalSubmitActionLabel() }}
            @endif
        </x-dynamic-component>
    </span>
@endif
