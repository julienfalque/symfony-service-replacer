<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Proxy;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \JulienFalque\SymfonyServiceReplacer\Proxy\Specification
 */
final class SpecificationTest extends TestCase
{
    public function test_it_provides_proxy_creation_requirements(): void
    {
        $service = new SpecificationTest\Service();

        $specification = new Specification('foo', $service);

        self::assertSame(SpecificationTest\Service::class, $specification->getClass());
        self::assertSame('foo', $specification->getServiceId());
        self::assertSame($service, $specification->getServiceInstance());
    }
}

namespace JulienFalque\SymfonyServiceReplacer\Proxy\SpecificationTest;

class Service
{
}
