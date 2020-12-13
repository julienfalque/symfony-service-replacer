<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\PropertyInjection;

class Main
{
    /** @var Injected|null */
    public $injected;

    public function getValue(): string
    {
        $injectedResult = $this->injected !== null ? $this->injected->getValue() : '[Missing dependency]';

        return "Real value from Main / {$injectedResult}";
    }
}
