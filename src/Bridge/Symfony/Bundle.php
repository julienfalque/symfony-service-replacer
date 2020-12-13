<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Bridge\Symfony;

use JulienFalque\SymfonyServiceReplacer\Bridge\Symfony\DependencyInjection\Compiler\{DecorateReplaceableServicesPass, ExtractReplaceableServiceAliasesPass};
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle as BaseBundle;

final class Bundle extends BaseBundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(
            new ExtractReplaceableServiceAliasesPass(),
            PassConfig::TYPE_BEFORE_OPTIMIZATION,
            -20000
        );
        $container->addCompilerPass(
            new DecorateReplaceableServicesPass(),
            PassConfig::TYPE_BEFORE_OPTIMIZATION,
            -20000
        );
    }
}
