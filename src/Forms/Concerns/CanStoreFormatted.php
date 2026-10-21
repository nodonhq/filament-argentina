<?php

namespace NodonHq\FilamentArgentina\Forms\Concerns;

use Closure;

trait CanStoreFormatted
{
    protected bool|Closure $storeFormatted = false;

    /** Save the value as shown (with separators) instead of only its digits. */
    public function storeFormatted(bool|Closure $condition = true): static
    {
        $this->storeFormatted = $condition;

        return $this;
    }

    public function shouldStoreFormatted(): bool
    {
        return (bool) $this->evaluate($this->storeFormatted);
    }
}
