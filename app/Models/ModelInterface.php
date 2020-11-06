<?php

namespace App\Models;

interface ModelInterface
{
    /**
     * @param $name
     * @return mixed
     */
    public function getAttribute($name);
}
