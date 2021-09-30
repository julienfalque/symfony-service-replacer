<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Bridge\Symfony;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Test\TestContainer as SymfonyTestContainer;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TestContainer extends SymfonyTestContainer
{
    private SymfonyTestContainer $decoratedTestContainer;
    private ReplacementMap $replacementMap;

    public function __construct(
        SymfonyTestContainer $decoratedTestContainer,
        ReplacementMap $replacementMap
    ) {
        $this->decoratedTestContainer = $decoratedTestContainer;
        $this->replacementMap = $replacementMap;
    }

    /**
     * @throws LogicException
     */
    public function set(string $id, $service): void
    {
        if ($this->replacementMap->knows($id)) {
            $this->replacementMap->replace($id, $service);

            return;
        }

        $this->decoratedTestContainer->set($id, $service);
    }

    public function restore(string $id): void
    {
        $this->replacementMap->restore($id);
    }

    public function compile(): void
    {
        $this->decoratedTestContainer->compile();
    }

    public function isCompiled(): bool
    {
        return $this->decoratedTestContainer->isCompiled();
    }

    public function getParameterBag(): ParameterBagInterface
    {
        return $this->decoratedTestContainer->getParameterBag();
    }

    public function getParameter(string $name)
    {
        return $this->decoratedTestContainer->getParameter($name);
    }

    public function hasParameter(string $name): bool
    {
        return $this->decoratedTestContainer->hasParameter($name);
    }

    public function setParameter(string $name, $value): void
    {
        $this->decoratedTestContainer->setParameter($name, $value);
    }

    public function has(string $id): bool
    {
        return $this->decoratedTestContainer->has($id);
    }

    public function get(string $id, int $invalidBehavior = 1): ?object
    {
        return $this->decoratedTestContainer->get($id, $invalidBehavior);
    }

    public function initialized(string $id): bool
    {
        return $this->decoratedTestContainer->initialized($id);
    }

    public function reset(): void
    {
        $this->decoratedTestContainer->reset();
    }

    public function getServiceIds(): array
    {
        return $this->decoratedTestContainer->getServiceIds();
    }

    public function getRemovedIds(): array
    {
        return $this->decoratedTestContainer->getRemovedIds();
    }
}
