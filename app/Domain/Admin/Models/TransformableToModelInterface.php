<?php

namespace App\Domain\Admin\Models;

use App\Models\ModelInterface;

interface TransformableToModelInterface
{
    public function transformToModel(): ModelInterface;
}
