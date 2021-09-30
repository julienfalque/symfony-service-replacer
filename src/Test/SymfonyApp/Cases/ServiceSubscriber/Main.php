<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\Cases\ServiceSubscriber;

use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class Main implements ServiceSubscriberInterface
{
    private ContainerInterface $locator;

    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    public function getValue(): string
    {
        return "Real value from Main / {$this->locator->get(Injected::class)->getValue()}";
    }

    /**
     * @return array<int|string, string>
     */
    public static function getSubscribedServices(): array
    {
        return [Injected::class];
    }
}
