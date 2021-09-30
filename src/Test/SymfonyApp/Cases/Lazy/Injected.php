<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\Lazy;

class Injected
{
    private static bool $instanciated = false;

    public static function wasInstanciated(): bool
    {
        return self::$instanciated;
    }

    public function __construct()
    {
        self::$instanciated = true;
    }

    public function getValue(): string
    {
        return 'Real value from Injected';
    }
}
