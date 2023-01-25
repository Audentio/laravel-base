<?php

namespace Audentio\LaravelBase\Foundation\Interfaces;

interface ModelInterface
{
    public function getContentType(): string;
    public function generateUniqueId(): string;
}
