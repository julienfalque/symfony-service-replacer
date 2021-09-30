<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\Decoration;

class Main
{
    private SomeInterface $injected;

    public function __construct(SomeInterface $injected)
    {
        $this->injected = $injected;
    }

    public function getValue(): string
    {
        return "Real value from Main / {$this->injected->getValue()}";
    }
}
