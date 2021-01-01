<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Proxy;

use JulienFalque\SymfonyServiceReplacer\ServiceReplacer;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \JulienFalque\SymfonyServiceReplacer\Proxy\Factory
 */
final class FactoryTest extends TestCase
{
    public function test_it_creates_a_proxy_from_a_proxy_specification(): void
    {
        $replacer = new ServiceReplacer([]);
        $factory = new Factory($replacer);

        $service = new FactoryTest\Service();
        $specification = new Specification('foo', $service);

        $proxy = $factory->createServiceProxy($specification);

        self::assertInstanceOf(Proxy::class, $proxy);
        self::assertInstanceOf(FactoryTest\Service::class, $proxy);

        self::assertSame('foo', $proxy->getValue());

        $replacer->replace('foo', new class() {
            public function getValue(): string
            {
                return 'bar';
            }
        });

        self::assertSame('bar', $proxy->getValue());

        $replacer->restore('foo');

        self::assertSame('foo', $proxy->getValue());
    }
}

namespace JulienFalque\SymfonyServiceReplacer\Proxy\FactoryTest;

/**
 * @internal
 */
class Service
{
    public function getValue(): string
    {
        return 'foo';
    }
}
