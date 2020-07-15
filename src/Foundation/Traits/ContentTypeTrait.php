<?php

namespace Audentio\LaravelBase\Foundation\Traits;

use Audentio\LaravelBase\Utils\ContentTypeUtil;

trait ContentTypeTrait
{
    public function getContent()
    {
        return $this->content;
    }

    public function content()
    {
        return $this->morphTo();
    }

    public function setContentTypeAttribute($value)
    {
        if (!empty($value)) {
            $value = ContentTypeUtil::getModelClassNameForContentType($value);
        }

        $this->attributes['content_type'] = $value;
    }
}