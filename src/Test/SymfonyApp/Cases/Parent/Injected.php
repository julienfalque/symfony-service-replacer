<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\Parent;

class Injected
{
    private string $argument;

    public function __construct(string $argument)
    {
        $this->argument = $argument;
    }

    public function getValue(): string
    {
        return 'Real value from Injected';
    }
}
