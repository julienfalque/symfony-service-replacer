<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\Parent;

class Injected
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return "{$this->value} from Injected";
    }
}
