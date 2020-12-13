<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\NonShared;

class Injected
{
    /** @var int */
    private static $instances = 0;

    /** @var int */
    private $instance;

    public function __construct()
    {
        $this->instance = ++self::$instances;
    }

    public function getValue(): string
    {
        return "Real value from Injected {$this->instance}";
    }
}
