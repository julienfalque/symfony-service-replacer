<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Test;

use JulienFalque\SymfonyServiceReplacer\Test\SymfonyApp\{Cases, Kernel};
use stdClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * @internal
 *
 * @coversNothing
 */
final class IntegrationTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function test_it_replaces_a_simple_service(): void
    {
        $entrypoint = self::getContainer()->get(Cases\Single\Main::class);

        self::assertSame(
            'Real value from Main',
            $entrypoint->getValue(),
        );

        $this->replaceService(Cases\Single\Main::class);

        self::assertSame(
            'Mocked value from Main',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_service_via_an_alias(): void
    {
        $entrypoint = self::getContainer()->get(Cases\Alias\Main::class);

        self::assertSame(
            'Real value from Main / Real value from Injected',
            $entrypoint->getValue(),
        );

        $this->replaceServiceUsingReturnValue(Cases\Alias\Injected::class.'.alias', 'Mocked value from Injected');

        self::assertSame(
            'Real value from Main / Mocked value from Injected',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_service_via_a_recursive_alias(): void
    {
        $entrypoint = self::getContainer()->get(Cases\Alias\Main::class);

        self::assertSame(
            'Real value from Main / Real value from Injected',
            $entrypoint->getValue(),
        );

        $this->replaceServiceUsingReturnValue(Cases\Alias\Injected::class.'.recursive_alias', 'Mocked value from Injected');

        self::assertSame(
            'Real value from Main / Mocked value from Injected',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_public_service(): void
    {
        $entrypoint = self::getContainer()->get(Cases\PublicService\Main::class);

        self::assertSame(
            'Real value from Main',
            $entrypoint->getValue(),
        );

        $this->replaceService(Cases\PublicService\Main::class);

        self::assertSame(
            'Mocked value from Main',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_service_injected_into_another_one_via_its_constructor(): void
    {
        $entrypoint = self::getContainer()->get(Cases\ConstructorInjection\Main::class);

        self::assertSame(
            'Real value from Main / Real value from Injected',
            $entrypoint->getValue(),
        );

        $this->replaceService(Cases\ConstructorInjection\Injected::class);

        self::assertSame(
            'Real value from Main / Mocked value from Injected',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_service_injected_into_another_one_via_a_setter(): void
    {
        $entrypoint = self::getContainer()->get(Cases\SetterInjection\Main::class);

        self::assertSame(
            'Real value from Main / Real value from Injected',
            $entrypoint->getValue(),
        );

        $this->replaceService(Cases\SetterInjection\Injected::class);

        self::assertSame(
            'Real value from Main / Mocked value from Injected',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_service_injected_into_another_one_via_an_immutable_setter(): void
    {
        $entrypoint = self::getContainer()->get(Cases\ImmutableSetterInjection\Main::class);

        self::assertSame(
            'Real value from Main / Real value from Injected',
            $entrypoint->getValue(),
        );

        $this->replaceService(Cases\ImmutableSetterInjection\Injected::class);

        self::assertSame(
            'Real value from Main / Mocked value from Injected',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_service_injected_into_another_one_via_a_public_property(): void
    {
        $entrypoint = self::getContainer()->get(Cases\PropertyInjection\Main::class);

        self::assertSame(
            'Real value from Main / Real value from Injected',
            $entrypoint->getValue(),
        );

        $this->replaceService(Cases\PropertyInjection\Injected::class);

        self::assertSame(
            'Real value from Main / Mocked value from Injected',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_service_that_uses_a_factory(): void
    {
        $entrypoint = self::getContainer()->get(Cases\Factory\Main::class);

        self::assertSame(
            'Real value from Main / Real value from Injected',
            $entrypoint->getValue(),
        );

        $this->replaceService(Cases\Factory\Injected::class);

        self::assertSame(
            'Real value from Main / Mocked value from Injected',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_decorated_service(): void
    {
        $entrypoint = self::getContainer()->get(Cases\Decoration\Main::class);

        self::assertSame(
            'Real value from Main / Real value from SecondDecorator / Real value from FirstDecorator / Real value from Decorated',
            $entrypoint->getValue(),
        );

        $this->replaceService(Cases\Decoration\Decorated::class);

        self::assertSame(
            'Real value from Main / Real value from SecondDecorator / Real value from FirstDecorator / Mocked value from Decorated',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_the_first_decorator_in_a_decoration_stack(): void
    {
        $entrypoint = self::getContainer()->get(Cases\Decoration\Main::class);

        self::assertSame(
            'Real value from Main / Real value from SecondDecorator / Real value from FirstDecorator / Real value from Decorated',
            $entrypoint->getValue(),
        );

        $this->replaceService(Cases\Decoration\FirstDecorator::class);

        self::assertSame(
            'Real value from Main / Real value from SecondDecorator / Mocked value from FirstDecorator',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_the_second_decorator_in_a_decoration_stack(): void
    {
        $entrypoint = self::getContainer()->get(Cases\Decoration\Main::class);

        self::assertSame(
            'Real value from Main / Real value from SecondDecorator / Real value from FirstDecorator / Real value from Decorated',
            $entrypoint->getValue(),
        );

        $this->replaceService(Cases\Decoration\SecondDecorator::class);

        self::assertSame(
            'Real value from Main / Mocked value from SecondDecorator',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_lazy_service(): void
    {
        $entrypoint = self::getContainer()->get(Cases\Lazy\Main::class);

        self::assertFalse(Cases\Lazy\Injected::wasInstanciated());
        self::assertSame(
            'Real value from Main / Real value from Injected',
            $entrypoint->getValue(),
        );
        self::assertTrue(Cases\Lazy\Injected::wasInstanciated());

        $this->replaceService(Cases\Lazy\Injected::class);

        self::assertSame(
            'Real value from Main / Mocked value from Injected',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_service_that_inherits_a_parent_definition(): void
    {
        $entrypoint = self::getContainer()->get(Cases\Parent\Main::class);

        self::assertSame(
            'Real value from Main / Real value from Injected',
            $entrypoint->getValue(),
        );

        $this->replaceService(Cases\Parent\Injected::class);

        self::assertSame(
            'Real value from Main / Mocked value from Injected',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_service_injected_via_a_service_locator(): void
    {
        $entrypoint = self::getContainer()->get(Cases\ServiceSubscriber\Main::class);

        self::assertSame(
            'Real value from Main / Real value from Injected',
            $entrypoint->getValue(),
        );

        $this->replaceService(Cases\ServiceSubscriber\Injected::class);

        self::assertSame(
            'Real value from Main / Mocked value from Injected',
            $entrypoint->getValue(),
        );
    }

    public function test_it_replaces_a_non_shared_service(): void
    {
        $entrypoint = self::getContainer()->get(Cases\NonShared\Main::class);

        self::assertSame(
            'Real value from Main / Real value from Injected 1',
            $entrypoint->getValueFromInjected1(),
        );
        self::assertSame(
            'Real value from Main / Real value from Injected 2',
            $entrypoint->getValueFromInjected2(),
        );

        $this->replaceService(Cases\NonShared\Injected::class);

        self::assertSame(
            'Real value from Main / Mocked value from Injected',
            $entrypoint->getValueFromInjected1(),
        );
        self::assertSame(
            'Real value from Main / Mocked value from Injected',
            $entrypoint->getValueFromInjected2(),
        );
    }

    public function test_it_restores_a_replaced_service(): void
    {
        $entrypoint = self::getContainer()->get(Cases\PublicService\Main::class);

        $this->replaceService(Cases\PublicService\Main::class);

        self::assertSame(
            'Mocked value from Main',
            $entrypoint->getValue(),
        );

        self::getContainer()->restore(Cases\PublicService\Main::class);

        self::assertSame(
            'Real value from Main',
            $entrypoint->getValue(),
        );
    }

    public function test_it_still_sets_a_synthetic_service(): void
    {
        $service = new stdClass();

        self::getContainer()->set('synthetic_service', $service);

        self::assertSame(
            $service,
            self::getContainer()->get('synthetic_service'),
        );
    }

    public function test_it_does_not_replace_a_non_replaceable_service(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "non_replaceable_service" service is private, you cannot replace it.');

        self::getContainer()->set('non_replaceable_service', new stdClass());
    }

    public function test_it_still_replaces_a_non_replaceable_but_public_service(): void
    {
        $service = new stdClass();

        self::getContainer()->set('non_replaceable_but_public_service', $service);

        self::assertSame(
            $service,
            self::getContainer()->get('non_replaceable_but_public_service'),
        );
    }

    /**
     * @param class-string $replacedServiceId
     */
    private function replaceService(string $replacedServiceId): void
    {
        $lastBacklash = strrpos($replacedServiceId, '\\');
        $className = substr($replacedServiceId, false !== $lastBacklash ? $lastBacklash + 1 : 0);

        $this->replaceServiceUsingReturnValue($replacedServiceId, "Mocked value from {$className}");
    }

    private function replaceServiceUsingReturnValue(string $replacedServiceId, string $returnValue): void
    {
        $mock = new class($returnValue) {
            private string $returnValue;

            public function __construct(string $returnValue)
            {
                $this->returnValue = $returnValue;
            }

            public function getValue(): string
            {
                return $this->returnValue;
            }
        };

        self::getContainer()->set($replacedServiceId, $mock);
    }

    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }
}
