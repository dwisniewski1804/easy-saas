<?php

namespace App\Models;

interface ModelInterface
{
    /**
     * @return mixed
     */
    public function getAttribute(string $name);
}
