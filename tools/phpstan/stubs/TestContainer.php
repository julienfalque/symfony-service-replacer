<?php

namespace Symfony\Bundle\FrameworkBundle\Test;

class TestContainer
{
    /**
     * @param mixed $service
     */
    public function set(string $id, $service): void;

    /**
     * @return array<mixed>|bool|string|int|float|null
     */
    public function getParameter(string $name);

    /**
     * @param array<mixed>|bool|string|int|float|null $value
     */
    public function setParameter(string $name, $value): void;

    /**
     * @return list<string>
     */
    public function getRemovedIds(): array;
}
