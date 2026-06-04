@php
    $resolved = [
        'mountHandler' => $action->getLivewireClickHandler(),
        'confirmHandler' => $action->getLivewireCallMountedActionName(),
        ...$manager->extractViewData($action),
    ];
    view()->share('resolved_action_view', $resolved);
@endphp
