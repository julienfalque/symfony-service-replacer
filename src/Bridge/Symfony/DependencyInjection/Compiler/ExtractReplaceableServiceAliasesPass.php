<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Bridge\Symfony\DependencyInjection\Compiler;

use JulienFalque\SymfonyServiceReplacer\ServiceReplacer;
use LogicException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\{ContainerBuilder, Exception\InvalidArgumentException};

/**
 * @internal
 */
final class ExtractReplaceableServiceAliasesPass implements CompilerPassInterface
{
    use ContainerManipulation;

    /**
     * @throws LogicException
     */
    public function process(ContainerBuilder $container): void
    {
        $replacer = $this->getDefinition($container, ServiceReplacer::class);

        $aliases = [];

        /** @var string $id */
        foreach (array_keys($container->getAliases()) as $id) {
            $serviceId = $this->resolveAlias($id, $container);

            if ($container->getDefinition($serviceId)->hasTag('replaceable')) {
                $aliases[$id] = $serviceId;
            }
        }

        $replacer->setArgument('$aliases', $aliases);
    }

    /**
     * @throws LogicException
     */
    private function resolveAlias(string $alias, ContainerBuilder $container): string
    {
        try {
            $id = $container->getAlias($alias);
        } catch (InvalidArgumentException $exception) {
            throw new LogicException("Alias \"{$alias}\" is not defined.", 0, $exception);
        }

        $id = (string) $id;

        if ($container->hasAlias($id)) {
            return $this->resolveAlias($id, $container);
        }

        return $id;
    }
}
