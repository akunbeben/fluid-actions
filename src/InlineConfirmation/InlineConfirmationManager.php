<?php

declare(strict_types=1);

namespace Akunbeben\InlineConfirm\InlineConfirmation;

use Akunbeben\InlineConfirm\Concerns\ManagesActionView;
use Closure;
use Filament\Actions\Action;

final class InlineConfirmationManager
{
    use ManagesActionView;

    protected function viewName(): string
    {
        return 'inline-confirm::action';
    }

    protected function configKey(): string
    {
        return 'inlineConfirmConfig';
    }

    protected function makeConfig(int $timing, ?string $originalView, bool | Closure | null $closeDropdown = null): InlineConfirmationConfig
    {
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
