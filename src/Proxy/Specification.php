<?php

declare(strict_types=1);

namespace JulienFalque\SymfonyServiceReplacer\Proxy;

use function get_class;

/**
 * @internal
 */
final class Specification
{
    /** @var string */
    private $serviceId;

    /** @var object */
    private $serviceInstance;

    public function __construct(string $serviceId, object $serviceInstance)
    {
        $this->serviceId = $serviceId;
        $this->serviceInstance = $serviceInstance;
    }

    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    public function getServiceInstance(): object
    {
        return $this->serviceInstance;
    }

    /**
     * @return class-string
     */
    public function getClass(): string
    {
        return get_class($this->serviceInstance);
    }
}
