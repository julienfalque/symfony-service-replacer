<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\Single;

class Main
{
    public function getValue(): string
    {
        return 'Real value from Main';
    }
}
