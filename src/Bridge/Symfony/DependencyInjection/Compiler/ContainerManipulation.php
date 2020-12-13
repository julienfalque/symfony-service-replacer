<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Bridge\Symfony\DependencyInjection\Compiler;

use LogicException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\{ContainerBuilder, Definition};

/**
 * @internal
 */
trait ContainerManipulation
{
    /**
     * @throws LogicException
     */
    private function getDefinition(ContainerBuilder $container, string $id): Definition
    {
        try {
            return $container->getDefinition($id);
        } catch (ServiceNotFoundException $exception) {
            throw new LogicException("Service \"{$id}\" is not defined.", 0, $exception);
        }
    }
}
