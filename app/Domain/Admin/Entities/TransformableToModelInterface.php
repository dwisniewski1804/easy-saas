<?php

namespace App\Domain\Admin\Entities;

use App\Models\ModelInterface;

interface TransformableToModelInterface
{
    public function transformToModel(): ModelInterface;
}
