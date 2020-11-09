<?php

namespace App\Domain\ValueObjects;

use App\Domain\DomainInputBagInterface;

class DomainInputBag implements DomainInputBagInterface
{
    private array $parameters;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function get(string $key, ?string $default = null)
    {
        return \array_key_exists($key, $this->parameters) ? $this->parameters[$key] : $default;
    }
}
