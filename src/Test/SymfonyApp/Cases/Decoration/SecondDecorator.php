<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\Decoration;

class SecondDecorator implements SomeInterface
{
    private SomeInterface $decorated;

    public function __construct(SomeInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function getValue(): string
    {
        return "Real value from SecondDecorator / {$this->decorated->getValue()}";
    }
}
