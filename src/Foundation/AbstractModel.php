<?php

namespace Audentio\LaravelBase\Foundation;

use Audentio\LaravelBase\Utils\KeyUtil;
use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $generateId = true;
    protected $generateType = 'uuid';
    protected $generateKeySeedBytes = 8;
    protected $checkIdCollisions = true;
    protected $refreshOnSave = false;

    protected $postSaveMethods = [];
    protected $originalAttributes = [];

    protected $contentType;

    public function getContentType(): string
    {
        return $this->contentType;
    }

    public function generateUniqueId(): string
    {
        switch($this->generateType) {
            case 'base64':
                $id = KeyUtil::guid($this->generateKeySeedBytes);
                break;

            default:
            case 'uuid':
                $id = KeyUtil::uuid();
                break;
        }

        if ($this->checkIdCollisions && self::where($this->getKeyName(), $id)->exists()) {
            return $this->generateUniqueId();
        }

        $this->{$this->getKeyName()} = $id;
        return $id;
    }

    public function preSave() {}
    public function postSave() {}

    public function preDelete() {}
    public function postDelete() {}

    public function save(array $options = [])
    {
        $this->originalAttributes = $this->getOriginal();
        if ($this->generateId && !$this->getKey()) {
            $this->generateUniqueId();
        }

        $this->preSave();

        $return = parent::save($options);

        $this->postSave();

        foreach ($this->postSaveMethods as $postSaveMethod) {
            if (method_exists($this, $postSaveMethod)) {
                $this->{$postSaveMethod}();
            }
        }

        if ($this->refreshOnSave) {
            $this->refresh();
        }
        return $return;
    }

    public function delete()
    {
        $this->preDelete();

        $return = parent::delete();

        $this->postDelete();

        return $return;
    }

    protected function guessContentType()
    {
        $this->contentType = get_class($this);
    }

    public function getOriginalAttribute($attribute)
    {
        return array_key_exists($attribute, $this->originalAttributes) ? $this->originalAttributes[$attribute] : null;
    }

    public function getOriginalAttributes()
    {
        return $this->originalAttributes;
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->guessContentType();
    }
}