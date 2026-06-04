<?php

declare(strict_types=1);

namespace Akunbeben\InlineConfirm\HoldToConfirm;

use Akunbeben\InlineConfirm\Concerns\ManagesActionView;
use Closure;
use Filament\Actions\Action;

final class HoldToConfirmManager
{
    use ManagesActionView;

    protected function viewName(): string
    {
        return 'inline-confirm::hold-to-confirm';
    }

    protected function configKey(): string
    {
        return 'holdToConfirmConfig';
    }

    protected function makeConfig(int $timing, ?string $originalView, bool | Closure | null $closeDropdown = null): HoldToConfirmConfig
    {
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
