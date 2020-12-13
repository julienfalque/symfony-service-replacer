<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\Factory;

class Factory
{
    public function createInjected(): Injected
    {
        return new Injected();
    }
}
