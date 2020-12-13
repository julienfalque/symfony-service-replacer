<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\Decoration;

class Decorated implements SomeInterface
{
    public function getValue(): string
    {
        return 'Real value from Decorated';
    }
}
