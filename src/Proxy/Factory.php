<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Proxy;

use JulienFalque\SymfonyServiceReplacer\Bridge\Symfony\ReplacementMap;
use Laminas\Code\Generator\Exception\InvalidArgumentException;
use Laminas\Code\Generator\{ClassGenerator, ParameterGenerator, PropertyGenerator};
use Laminas\Code\Reflection\MethodReflection;
use OutOfBoundsException;
use ProxyManager\Exception\InvalidProxiedClassException;
use ProxyManager\Factory\AbstractBaseFactory;
use ProxyManager\Generator\MethodGenerator;
use ProxyManager\ProxyGenerator\Assertion\CanProxyAssertion;
use ProxyManager\ProxyGenerator\ProxyGeneratorInterface;
use ProxyManager\ProxyGenerator\Util\ProxiedMethodsFilter;
use ProxyManager\Signature\Exception\{InvalidSignatureException, MissingSignatureException};
use ReflectionClass;
use RuntimeException;

/**
 * @internal
 */
final class Factory extends AbstractBaseFactory
{
    /** @var ReplacementMap */
    private $replacementMap;

    public function __construct(ReplacementMap $replacementMap)
    {
        parent::__construct();

        $this->replacementMap = $replacementMap;
    }

    /**
     * @throws RuntimeException
     */
    public function createServiceProxy(Specification $specification): object
    {
        try {
            /** @var class-string<Proxy> $proxyClassName */
            $proxyClassName = $this->generateProxy($specification->getClass());
        } catch (InvalidSignatureException | MissingSignatureException | OutOfBoundsException $exception) {
            throw new RuntimeException("Failed creating a proxy for class {$specification->getClass()}.", 0, $exception);
        }

        $replacementMap = $this->replacementMap;

        $getService = static function () use ($replacementMap, $specification): object {
            $replacement = $replacementMap->getReplacementFor($specification->getServiceId());

            if ($replacement !== null) {
                return $replacement;
            }

            return $specification->getServiceInstance();
        };

        return new $proxyClassName($getService);
    }

    protected function getGenerator(): ProxyGeneratorInterface
    {
        return new class() implements ProxyGeneratorInterface {
            /**
             * @throws InvalidProxiedClassException
             * @throws InvalidArgumentException
             */
            public function generate(ReflectionClass $originalClass, ClassGenerator $classGenerator): void
            {
                CanProxyAssertion::assertClassCanBeProxied($originalClass);

                $interfaces = [Proxy::class];

                if ($originalClass->isInterface()) {
                    $interfaces[] = $originalClass->getName();
                } else {
                    $classGenerator->setExtendedClass($originalClass->getName());
                }

                $classGenerator->setImplementedInterfaces($interfaces);

                $getServiceProperty = new PropertyGenerator('getService', null, PropertyGenerator::FLAG_PRIVATE);
                $getServiceProperty->omitDefaultValue();
                $classGenerator->addPropertyFromGenerator($getServiceProperty);

                $classGenerator->addMethod(
                    '__construct',
                    [
                        new ParameterGenerator('getService', 'callable'),
                    ],
                    MethodGenerator::FLAG_PUBLIC,
                    '$this->getService = $getService;'
                );

                foreach (ProxiedMethodsFilter::getProxiedMethods($originalClass, []) as $method) {
                    $proxyMethod = MethodGenerator::fromReflectionWithoutBodyAndDocBlock(
                        new MethodReflection($method->getDeclaringClass()->getName(), $method->getName())
                    );

                    $returnType = $proxyMethod->getReturnType();

                    $proxyMethod->setBody(sprintf(
                        '%s($this->getService)()->%s(%s);',
                        $returnType !== null && $returnType->generate() !== 'void' ? 'return ' : '',
                        $proxyMethod->getName(),
                        implode(', ', array_map(
                            static fn (ParameterGenerator $parameter): string => '$'.$parameter->getName(),
                            $proxyMethod->getParameters()
                        ))
                    ));

                    $classGenerator->addMethodFromGenerator($proxyMethod);
                }
            }
        };
    }
}
