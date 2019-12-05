<?php

namespace Audentio\LaravelBase\Http\Controllers\Api;

use Audentio\LaravelBase\Http\Controllers\AbstractController;
use Audentio\LaravelBase\Http\Controllers\Traits\ApiControllerTrait;

abstract class AbstractApiController extends AbstractController
{
    use ApiControllerTrait;
}