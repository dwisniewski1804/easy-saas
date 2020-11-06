<?php

namespace App\Domain;

interface DomainInputBagInterface
{
    public function __construct(array $parameters = []);
    public function get(string $name);
}
