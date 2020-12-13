<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\Lazy;

class Injected
{
    /** @var bool */
    private static $instanciated = false;

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
