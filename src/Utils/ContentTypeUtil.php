<?php

namespace Audentio\LaravelBase\Utils;

class ContentTypeUtil
{
    protected static array $instances = [];

    protected string $contentType;
    protected array $contentTypeFields = [];

    public function __get($name)
    {
        switch ($name) {
            case 'contentType':
                return $this->contentType;

            default:
                if (array_key_exists($name, $this->contentTypeFields)) {
                    return $this->contentTypeFields[$name];
                }
        }

        return null;
    }

    public static function getModelByContentTypeAndId($contentType, $contentId, array $with = [])
    {
        $modelClass = self::getModelClassNameForContentType($contentType);

        return $modelClass::with($with)->find($contentId);
    }

    public static function getModelClassNameForContentType($contentType): string
    {
        self::normalizeContentType($contentType);

        return $contentType;
    }

    public static function normalizeContentType(&$contentType): void
    {
        if (!str_contains($contentType, 'App\Models')) {
            $contentType = 'App\Models\\' . $contentType;
        }
    }

    public static function getContentTypeField($field): array
    {
        $values = [];

        foreach (self::getContentTypes() as $contentType) {
            $contentTypeObj = self::get($contentType);
            $value = $contentTypeObj->{$field};
            if ($value !== null) {
                $values[$contentType] = $value;
            }
        }

        return $values;
    }

    public static function getContentTypes(bool $friendly = false): array
    {
        $contentTypes = config('contentTypes');
        $contentTypes = array_keys($contentTypes);

        if ($friendly) {
            foreach ($contentTypes as &$contentType) {
                $contentType = self::getFriendlyContentTypeName($contentType);
            }
        }

        return $contentTypes;
    }

    public function getUploadHandlerConfig($contentField): ?array
    {
        $uploadHandler = $this->getUploadHandler($contentField);

        if (!$uploadHandler) {
            return null;
        }

        if (!array_key_exists('config', $uploadHandler)) {
            return [];
        }

        return $uploadHandler['config'];
    }

    public function getUploadHandlerClass($contentField): ?string
    {
        $uploadHandler = $this->getUploadHandler($contentField);

        if (!$uploadHandler) {
            return null;
        }

        return $uploadHandler['class'];
    }

    public function getUploadHandler($contentField): ?array
    {
        if (!isset($this->contentTypeFields['uploadHandlers'][$contentField])) {
            return null;
        }

        return $this->contentTypeFields['uploadHandlers'][$contentField];
    }

    public static function getFriendlyContentTypeName($contentType, bool $lcFirst = false): string
    {
        $contentType = class_basename($contentType);

        if ($lcFirst) {
            $contentType = lcfirst($contentType);
        }

        return $contentType;
    }

    /**
     * @param $contentType
     * @return ContentTypeUtil|null
     */
    public static function get($contentType): ?ContentTypeUtil
    {
        self::normalizeContentType($contentType);

        if (!isset(self::$instances[$contentType])) {
            $contentTypes = config('contentTypes');
            if (!isset($contentTypes[$contentType])) {
                return null;
            }

            self::$instances[$contentType] = new ContentTypeUtil($contentType, $contentTypes[$contentType]);
        }

        return self::$instances[$contentType];
    }

    public function __construct($contentType, array $contentTypeFields)
    {
        $this->contentType = $contentType;
        $this->contentTypeFields = $contentTypeFields;
    }
}