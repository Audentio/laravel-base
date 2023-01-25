<?php

namespace Audentio\LaravelBase\Foundation;

use Audentio\LaravelBase\Foundation\Interfaces\ModelInterface;
use Audentio\LaravelBase\Foundation\Traits\ModelTrait;
use Audentio\LaravelBase\Utils\KeyUtil;
use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model implements ModelInterface
{
    use ModelTrait;
}