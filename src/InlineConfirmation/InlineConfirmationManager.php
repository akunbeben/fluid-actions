<?php

namespace Akunbeben\InlineConfirm\InlineConfirmation;

use Closure;
use Filament\Actions\Action;

final class InlineConfirmationManager
{
    /** @var array<string, InlineConfirmationConfig> */
    private array $configs = [];

    public function enable(Action $action, int $timeout = 3000): Action
    {
        $explicitView = Closure::bind(fn (): ?string => $this->view ?? null, $action, $action)();
        $originalView = $this->for($action)->originalView ?? $explicitView;

        $this->configs[$action->getName()] = new InlineConfirmationConfig($timeout, $originalView);

        $action->view('inline-confirm::action');

        return $action;
    }

    public function for(Action $action): ?InlineConfirmationConfig
    {
        return $this->configs[$action->getName()] ?? null;
    }

    public function renderOriginalAction(Action $action, bool $isLivewireClickHandlerEnabled = true): string
    {
        $config = $this->for($action);

        if (! $config instanceof InlineConfirmationConfig) {
            return $this->renderFallbackAction($action, $isLivewireClickHandlerEnabled);
        }

        $clone = $action->getClone();

        Closure::bind(function () use ($clone, $config): void {
            if ($config->originalView !== null) {
                $clone->view = $config->originalView;
            } else {
                /** @phpstan-ignore unset.possiblyHookedProperty */
                unset($clone->view);
            }
        }, null, $clone)();

        $this->resetViewInstance($clone);

        $clone->livewireClickHandlerEnabled($isLivewireClickHandlerEnabled);

        return $clone->toHtml();
    }

    private function renderFallbackAction(Action $action, bool $isLivewireClickHandlerEnabled = true): string
    {
        $clone = $action->getClone();

        Closure::bind(function () use ($clone): void {
            /** @phpstan-ignore unset.possiblyHookedProperty */
            unset($clone->view);
        }, null, $clone)();

        $this->resetViewInstance($clone);

        $clone->livewireClickHandlerEnabled($isLivewireClickHandlerEnabled);

        return $clone->toHtml();
    }

    private function resetViewInstance(Action $action): void
    {
        Closure::bind(
            function (): void {
                /** @phpstan-ignore unset.possiblyHookedProperty */
                unset($this->viewInstance);
            },
            $action,
            $action,
        )();
    }
}
