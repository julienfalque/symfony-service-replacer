<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Bridge\Symfony\DependencyInjection\Compiler;

use JulienFalque\SymfonyServiceReplacer\Bridge\Symfony\{ReplacementMap, SpecificationFactory};
use JulienFalque\SymfonyServiceReplacer\Proxy\Factory;
use LogicException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\{ContainerBuilder, Definition, Reference};
use Symfony\Component\ExpressionLanguage\Expression;

/**
 * @internal
 */
final class DecorateReplaceableServicesPass implements CompilerPassInterface
{
    use ContainerManipulation;

    /**
     * @throws LogicException
     */
    public function process(ContainerBuilder $container): void
    {
        $specificationFactoryEscapedId = $this->escapeExpressionString(SpecificationFactory::class);

        $decoratedServicesMap = [];

        /** @var string $serviceId */
        foreach (array_keys($container->findTaggedServiceIds('replaceable')) as $serviceId) {
            $service = $container->getDefinition($serviceId);

            $proxyId = "{$serviceId}.replacement_proxy";

            $replacedServiceEscapedId = $this->escapeExpressionString($serviceId);

            $proxy = new Definition($service->getClass());
            $proxy->setDecoratedService($serviceId, null, 20000);
            $proxy->setFactory([new Reference(Factory::class), 'createServiceProxy']);
            $proxy->setArguments([new Expression("service('{$specificationFactoryEscapedId}').createSpecificationFor('{$replacedServiceEscapedId}')")]);
            $proxy->setShared($service->isShared());

            $container->setDefinition($proxyId, $proxy);

            $decoratedServicesMap[$serviceId] = new Reference("{$proxyId}.inner");
        }

        $replacementMap = $this->getDefinition($container, ReplacementMap::class);
        $replacementMap->setArgument('$replaceableIds', array_keys($decoratedServicesMap));

        $specificationFactory = $this->getDefinition($container, SpecificationFactory::class.'.specification_factory_locator');
        $specificationFactory->setArguments([$decoratedServicesMap]);
    }

    private function escapeExpressionString(string $value): string
    {
        return str_replace('\\', '\\\\\\', $value);
    }
}
