<?php

namespace Audentio\LaravelBase\Foundation\Traits;

use Audentio\LaravelBase\Utils\KeyUtil;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait ModelTrait
{
    protected bool $generateId = true;
    protected string $generateType = 'uuid';
    protected int $generateKeySeedBytes = 8;
    protected bool $checkIdCollisions = true;
    protected string $contentType;

    public function getContentType(): string
    {
        return $this->contentType;
    }

    public function guessContentType(): void
    {
        $this->contentType = get_class($this);
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

    public function initializeModelTrait(): void
    {
        $this->guessContentType();
        $this->incrementing = false;
        $this->keyType = 'string';
    }

    protected function asDateTime($value): Carbon
    {
        if (config('audentioBase.convertDateTimeToAppTimezoneBeforeSaving')) {
            if ($value instanceof \DateTimeInterface) {
                if ($value->getTimezone() !== config('app.timezone')) {
                    $value->setTimezone(new \DateTimeZone(config('app.timezone')));
                }
            }
        }

        return parent::asDateTime($value);
    }

    public static function bootModelTrait(): void
    {
        /** @var ModelTrait $model */
        static::creating(function (Model $model) {
            if ($model->generateId && !$model->getKey()) {
                $model->generateUniqueId();
            }
        });
    }

    public static function getContentTypeFields(): array
    {
        $className =  get_called_class();
        $reflector = new \ReflectionClass($className);
        $methods = $reflector->getMethods(\ReflectionMethod::IS_STATIC);
        $instance = new $className;
        $contentTypeFields = [];
        foreach ($methods as $method) {
            $methodName = $method->getName();
            if (strpos($methodName, 'contentTypeFields__') === 0) {
                $fields = call_user_func([$className, $methodName], $instance);
                $contentTypeFields = array_replace_recursive($contentTypeFields, $fields);
            }
        }
        return $contentTypeFields;
    }
}
