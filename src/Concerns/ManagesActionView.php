<?php

declare(strict_types=1);

namespace Akunbeben\InlineConfirm\Concerns;

use Closure;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Table;

trait ManagesActionView
{
    /** @var array<string, object> */
    private array $configs = [];

    abstract protected function viewName(): string;

    abstract protected function makeConfig(int $timing, ?string $originalView, bool | Closure | null $closeDropdown): object;

    protected function configFor(string $name): ?object
    {
        return $this->configs[$name] ?? null;
    }

    public function extractViewData(Action $action): array
    {
        $isGrouped = $action->getGroup() instanceof ActionGroup;
        $config = $this->configFor($action->getName());
        $originalView = $config->originalView ?? $action->getDefaultView();

        $viewComponent = match ($originalView) {
            'filament::components.badge' => 'filament::badge',
            'filament::components.dropdown.list.item' => 'filament::dropdown.list.item',
            'filament::components.icon-button' => 'filament::icon-button',
            'filament::components.link' => 'filament::button',
            default => 'filament::button',
        };

        $icon = $action->getIcon();

        if (blank($icon)) {
            if ($viewComponent === 'filament::dropdown.list.item') {
                $icon = $action->getGroupedIcon();
            } elseif ($action->getTable() instanceof Table) {
                $icon = $action->getTableIcon();
            }
        }

        $closeDropdown = clone $action;
        $hasConfirmation = $closeDropdown->isConfirmationRequired();

        $shouldCloseDropdown = $hasConfirmation;
        if ($config && property_exists($config, 'closeDropdown') && $config->closeDropdown !== null) {
            $shouldCloseDropdown = (bool) $action->evaluate($config->closeDropdown);
        }

        return [
            'isGrouped' => $isGrouped,
            'closeDropdown' => $shouldCloseDropdown,
            'viewComponent' => $viewComponent,
            'icon' => $icon,
        ];
    }

    protected function storeConfig(Action $action, int $timing, bool | Closure | null $closeDropdown = null): Action
    {
        $explicitView = Closure::bind(fn (): ?string => $this->view ?? null, $action, $action)();
        $originalView = $this->configFor($action->getName())->originalView ?? $explicitView;

        $this->configs[$action->getName()] = $this->makeConfig($timing, $originalView, $closeDropdown);

        $action->view($this->viewName());

        return $action;
    }

    public function renderOriginalAction(Action $action, bool $isLivewireClickHandlerEnabled = true): string
    {
        $config = $this->configFor($action->getName());

        if ($config === null) {
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
