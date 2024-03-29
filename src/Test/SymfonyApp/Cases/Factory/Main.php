<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\Factory;

class Main
{
    private Injected $injected;

    public function __construct(Injected $injected)
    {
        $this->injected = $injected;
    }

    public function getValue(): string
    {
        return "Real value from Main / {$this->injected->getValue()}";
    }
}
