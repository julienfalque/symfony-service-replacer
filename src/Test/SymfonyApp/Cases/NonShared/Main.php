<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\NonShared;

class Main
{
    /** @var Injected */
    private $injected1;

    /** @var Injected */
    private $injected2;

    public function __construct(Injected $injected1, Injected $injected2)
    {
        $this->injected1 = $injected1;
        $this->injected2 = $injected2;
    }

    public function getValueFromInjected1(): string
    {
        return "Real value from Main / {$this->injected1->getValue()}";
    }

    public function getValueFromInjected2(): string
    {
        return "Real value from Main / {$this->injected2->getValue()}";
    }
}
