<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\ImmutableSetterInjection;

class Main
{
    /** @var Injected|null */
    private $injected;

    /**
     * @return static
     */
    public function setInjected(Injected $injected): self
    {
        $new = clone $this;
        $new->injected = $injected;

        return $new;
    }

    public function getValue(): string
    {
        $injectedResult = $this->injected !== null ? $this->injected->getValue() : '[Missing dependency]';

        return "Real value from Main / {$injectedResult}";
    }
}
