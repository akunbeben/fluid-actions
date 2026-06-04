@php
    $manager = app(\Akunbeben\InlineConfirm\HoldToConfirm\HoldToConfirmManager::class);
    $eligibility = app(\Akunbeben\InlineConfirm\HoldToConfirm\HoldToConfirmEligibility::class);
    $config = $manager->for($action);
@endphp

@if (! $eligibility->isEligible($action))
    {!! $manager->renderOriginalAction($action) !!}
@else
    @php
        $mountHandler = $action->getLivewireClickHandler();
        $confirmHandler = $action->getLivewireCallMountedActionName();
        ['isGrouped' => $isGrouped, 'closeDropdown' => $closeDropdown, 'viewComponent' => $viewComponent, 'icon' => $icon] = $manager->extractViewData($action);

        $clone = $action->getClone();
        $clone->extraAttributes([
            'class' => 'htc-trigger',
            'x-bind:class' => "{ 'is-holding': holding, 'is-processing': processing }",
            'x-on:mousedown.prevent' => 'start()',
            'x-on:mouseup.window' => 'cancel()',
            'x-on:mouseleave' => 'cancel()',
            'x-on:touchstart.prevent' => 'start()',
            'x-on:touchend.window' => 'cancel()',
            'x-on:touchcancel' => 'cancel()',
            'x-on:contextmenu.prevent' => 'true',
        ], merge: true);
    @endphp

    <span
        x-data="holdToConfirmAction({
            duration: @js($config?->duration ?? 1500),
            isGrouped: @js($isGrouped),
            shouldCloseDropdown: @js($closeDropdown),
        })"
        x-on:htc-complete="
            $wire.{!! $mountHandler !!};
            $wire.{!! $confirmHandler !!}().finally(() => { done() })
        "
        class="htc-action"
        style="--htc-duration: {{ $config?->duration ?? 1500 }}ms"
    >
        {!! $manager->renderOriginalAction($clone, isLivewireClickHandlerEnabled: false) !!}
    </span>
@endif
