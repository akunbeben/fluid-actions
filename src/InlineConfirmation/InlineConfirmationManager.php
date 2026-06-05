<?php

declare(strict_types=1);

namespace Akunbeben\FluidActions\InlineConfirmation;

use Akunbeben\FluidActions\Concerns\ManagesActionView;
use Closure;
use Filament\Actions\Action;

final class InlineConfirmationManager
{
    use ManagesActionView;

    protected function viewName(): string
    {
        return 'fluid-actions::action';
    }

    protected function configKey(): string
    {
        return 'inlineConfirmConfig';
    }

    protected function makeConfig(mixed ...$args): InlineConfirmationConfig
    {
        $timing = $args[0];
        $originalView = $args[1] ?? null;
        $closeDropdown = $args[2] ?? null;

        return new InlineConfirmationConfig($timing, $originalView, $closeDropdown);
    }

    public function enable(Action $action, int $timeout = 3000, bool | Closure | null $closeDropdown = null): Action
    {
        return $this->storeConfig($action, $timeout, $closeDropdown);
    }

    public function for(Action $action): ?InlineConfirmationConfig
    {
        /** @var ?InlineConfirmationConfig */
        return $this->configFor($action);
    }
}
