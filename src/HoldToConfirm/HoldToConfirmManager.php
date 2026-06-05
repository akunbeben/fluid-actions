<?php

declare(strict_types=1);

namespace Akunbeben\FluidActions\HoldToConfirm;

use Akunbeben\FluidActions\Concerns\ManagesActionView;
use Closure;
use Filament\Actions\Action;

final class HoldToConfirmManager
{
    use ManagesActionView;

    protected function viewName(): string
    {
        return 'fluid-actions::hold-to-confirm';
    }

    protected function configKey(): string
    {
        return 'holdToConfirmConfig';
    }

    protected function makeConfig(mixed ...$args): HoldToConfirmConfig
    {
        $timing = $args[0];
        $originalView = $args[1] ?? null;
        $closeDropdown = $args[2] ?? null;

        return new HoldToConfirmConfig($timing, $originalView, $closeDropdown);
    }

    public function enable(Action $action, int $duration = 1500, bool | Closure | null $closeDropdown = null): Action
    {
        return $this->storeConfig($action, $duration, $closeDropdown);
    }

    public function for(Action $action): ?HoldToConfirmConfig
    {
        /** @var ?HoldToConfirmConfig */
        return $this->configFor($action);
    }
}
