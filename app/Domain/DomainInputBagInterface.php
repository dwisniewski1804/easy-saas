<?php

namespace App\Domain;

interface DomainInputBagInterface
{
    public function __construct(array $parameters = []);

    /**
     * @return mixed
     */
    public function get(string $name, ?string $default = null);
}
