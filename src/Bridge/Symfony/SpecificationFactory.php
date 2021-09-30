<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Bridge\Symfony;

use JulienFalque\SymfonyServiceReplacer\Proxy\Specification;
use LogicException;
use Psr\Container\ContainerInterface;
use Throwable;

/**
 * @internal
 */
final class SpecificationFactory
{
    private ContainerInterface $decoratedServiceLocator;

    public function __construct(ContainerInterface $decoratedServiceLocator)
    {
        $this->decoratedServiceLocator = $decoratedServiceLocator;
    }

    /**
     * @throws LogicException
     */
    public function createSpecificationFor(string $replacedServiceId): Specification
    {
        try {
            /** @var object $replacedService */
            $replacedService = $this->decoratedServiceLocator->get($replacedServiceId);
        } catch (Throwable $exception) {
            throw new LogicException(
                "Cannot create proxy specification for service \"{$replacedServiceId}\": an error occured while fetching the service.",
                0,
                $exception,
            );
        }

        return new Specification($replacedServiceId, $replacedService);
    }
}
