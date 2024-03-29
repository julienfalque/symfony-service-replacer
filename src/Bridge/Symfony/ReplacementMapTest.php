<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Bridge\Symfony;

use PHPUnit\Framework\TestCase;

/**
 * @nternal
 *
 * @covers \JulienFalque\SymfonyServiceReplacer\Bridge\Symfony\ReplacementMap
 */
final class ReplacementMapTest extends TestCase
{
    public function test_it_returns_nothing_for_not_replaced_service(): void
    {
        $replacer = new ReplacementMap([], []);

        self::assertNull($replacer->getReplacementFor('foo'));
    }

    public function test_it_returns_the_replacement_service_when_set(): void
    {
        $replacement = new class() { };

        $replacer = new ReplacementMap(['foo'], []);
        $replacer->replace('foo', $replacement);

        self::assertSame($replacement, $replacer->getReplacementFor('foo'));
    }

    public function test_it_allows_unsetting_a_service_replacement(): void
    {
        $replacer = new ReplacementMap(['foo'], []);
        $replacer->replace('foo', new class() { });
        $replacer->restore('foo');

        self::assertNull($replacer->getReplacementFor('foo'));
    }

    public function test_it_resolves_services_aliases(): void
    {
        $replacement = new class() { };

        $replacer = new ReplacementMap(['foo'], [
            'bar' => 'foo',
        ]);

        self::assertNull($replacer->getReplacementFor('foo'));
        self::assertNull($replacer->getReplacementFor('bar'));

        $replacer->replace('bar', $replacement);

        self::assertSame($replacement, $replacer->getReplacementFor('foo'));
        self::assertSame($replacement, $replacer->getReplacementFor('bar'));

        $replacer->restore('bar');

        self::assertNull($replacer->getReplacementFor('foo'));
        self::assertNull($replacer->getReplacementFor('bar'));
    }
}
