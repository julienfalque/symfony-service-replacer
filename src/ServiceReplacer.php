<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer;

final class ServiceReplacer
{
    /** @var array<string, string> */
    private $aliases;

    /** @var array<string, object> */
    private $replacements = [];

    /**
     * @param array<string, string> $aliases
     */
    public function __construct(array $aliases)
    {
        $this->aliases = $aliases;
    }

    public function replace(string $id, object $replacement): void
    {
        $id = $this->resolveAlias($id);
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
