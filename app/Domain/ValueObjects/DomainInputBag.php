<?php

namespace App\Domain\ValueObjects;

use App\Domain\DomainInputBagInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class DomainInputBag extends ParameterBag implements DomainInputBagInterface
{
    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);
    }
}
