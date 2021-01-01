<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use function function_exists;
use JulienFalque\SymfonyServiceReplacer\Bridge\Symfony\SpecificationFactory;
use JulienFalque\SymfonyServiceReplacer\Proxy\Factory;
use JulienFalque\SymfonyServiceReplacer\ServiceReplacer;
use Symfony\Component\DependencyInjection\ServiceLocator;

return static function (ContainerConfigurator $container): void {
    // `ref()` was replaced with `service()` in symfony/dependency-injection v5.1
    $service = function_exists(__NAMESPACE__.'\\service') ? __NAMESPACE__.'\\service' : __NAMESPACE__.'\\ref';

    $specificationFactoryServiceLocator = SpecificationFactory::class.'.specification_factory_locator';

    $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()

        ->set(Factory::class)

        ->set(SpecificationFactory::class)
        ->args([$service($specificationFactoryServiceLocator)])

        ->set($specificationFactoryServiceLocator, ServiceLocator::class)

        ->set(ServiceReplacer::class)
        ->public()

        ->alias('service_replacer', ServiceReplacer::class)
        ->public()
    ;
};
