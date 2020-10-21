<?php

namespace App\Domains\Admin\Models;

use App\Models\ModelInterface;

interface TransformableToModelInterface
{
    public function transformToModel(): ModelInterface;
}
