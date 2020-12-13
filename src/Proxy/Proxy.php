<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Proxy;

interface Proxy
{
    public function __construct(callable $getService);
}
