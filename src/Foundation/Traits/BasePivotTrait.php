<?php

namespace Audentio\LaravelBase\Foundation\Traits;

use Audentio\LaravelBase\Foundation\AbstractModel;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

trait BasePivotTrait
{
    use AsPivot;

    public function getPivotParent(): AbstractModel
    {
        /** @var AbstractModel $parent */
        $parent = $this->pivotParent;

        return $parent;
    }
}