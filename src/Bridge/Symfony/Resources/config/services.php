<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use JulienFalque\SymfonyServiceReplacer\Bridge\Symfony\SpecificationFactory;
use JulienFalque\SymfonyServiceReplacer\Proxy\Factory;
use JulienFalque\SymfonyServiceReplacer\ServiceReplacer;
use Symfony\Component\DependencyInjection\ServiceLocator;

return static function (ContainerConfigurator $container): void {
    $specificationFactoryServiceLocator = SpecificationFactory::class.'.specification_factory_locator';

    $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()

        ->set(Factory::class)

        ->set(SpecificationFactory::class)
        ->args([service($specificationFactoryServiceLocator)])

        ->set($specificationFactoryServiceLocator, ServiceLocator::class)

        ->set(ServiceReplacer::class)
        ->public()

        ->alias('service_replacer', ServiceReplacer::class)
        ->public()
    ;
};
