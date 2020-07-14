<?php

namespace Audentio\LaravelBase\Foundation;

use Audentio\LaravelBase\Foundation\Traits\BasePivotTrait;

abstract class AbstractPivot extends AbstractModel
{
    use BasePivotTrait;

    protected $generateId = false;
}