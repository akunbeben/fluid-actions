<?php

namespace Akunbeben\InlineConfirm\InlineConfirmation;

use Filament\Actions\Action;
use WeakMap;

final class InlineConfirmationManager
{
    /** @var WeakMap<Action, InlineConfirmationConfig> */
    private WeakMap $configs;

    public function __construct()
    {
        $this->configs = new WeakMap;
    }

    public function enable(Action $action, ?string $label = null, int $timeout = 3000): Action
    {
        $originalView = $this->configs[$action]->originalView ?? $action->getView();

        $this->configs[$action] = new InlineConfirmationConfig($label, $timeout, $originalView);

        $action->view('inline-confirm::action');

        return $action;
    }

    public function for(Action $action): ?InlineConfirmationConfig
    {
        return $this->configs[$action] ?? null;
    }

    public function renderOriginalAction(Action $action, bool $isLivewireClickHandlerEnabled = true): string
    {
        $config = $this->for($action);
        $clone = $action->getClone();

        if ($config !== null) {
            $clone->view($config->originalView);
        }

        $clone->livewireClickHandlerEnabled($isLivewireClickHandlerEnabled);

        return $clone->toHtml();
    }
}
