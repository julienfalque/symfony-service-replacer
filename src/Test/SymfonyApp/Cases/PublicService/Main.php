<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\PublicService;

class Main
{
    public function getValue(): string
    {
        return 'Real value from Main';
    }
}
