<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\Alias;

class Injected
{
    public function getValue(): string
    {
        return 'Real value from Injected';
    }
}
