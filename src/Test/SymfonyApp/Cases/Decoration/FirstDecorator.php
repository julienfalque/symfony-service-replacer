<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\Decoration;

class FirstDecorator implements SomeInterface
{
    /** @var SomeInterface */
    private $decorated;

    public function __construct(SomeInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function getValue(): string
    {
        return "Real value from FirstDecorator / {$this->decorated->getValue()}";
    }
}
