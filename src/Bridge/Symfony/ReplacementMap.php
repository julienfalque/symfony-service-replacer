<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Bridge\Symfony;

use LogicException;

/**
 * @internal
 */
final class ReplacementMap
{
    /** @var array<string, true> */
    private array $replaceableIds;

    /** @var array<string, string> */
    private array $aliases;

    /** @var array<string, object> */
    private array $replacements = [];

    /**
     * @param list<string>          $replaceableIds
     * @param array<string, string> $aliases
     */
    public function __construct(
        array $replaceableIds,
        array $aliases
    ) {
        $this->replaceableIds = [];
        foreach ($replaceableIds as $id) {
            $this->replaceableIds[$id] = true;
        }

        $this->aliases = $aliases;
    }

    public function knows(string $id): bool
    {
        $id = $this->resolveAlias($id);

        return isset($this->replaceableIds[$id]);
    }

    /**
     * @throws LogicException
     */
    public function replace(string $id, object $replacement): void
    {
        $id = $this->resolveAlias($id);

        if (!$this->knows($id)) {
            throw new LogicException("Service \"{$id}\" is not replaceable.");
        }

        $this->replacements[$id] = $replacement;
    }

    public function getReplacementFor(string $id): ?object
    {
        $id = $this->resolveAlias($id);

        return $this->replacements[$id] ?? null;
    }

    public function restore(string $id): void
    {
        $id = $this->resolveAlias($id);
        unset($this->replacements[$id]);
    }

    private function resolveAlias(string $id): string
    {
        return $this->aliases[$id] ?? $id;
    }
}
