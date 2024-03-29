<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\SetterInjection;

class Main
{
    private ?Injected $injected = null;

    public function setInjected(Injected $injected): void
    {
        $this->injected = $injected;
    }

    public function getValue(): string
    {
        $injectedResult = $this->injected !== null ? $this->injected->getValue() : '[Missing dependency]';

        return "Real value from Main / {$injectedResult}";
    }
}
