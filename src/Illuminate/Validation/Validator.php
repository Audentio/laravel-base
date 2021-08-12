<?php

namespace Audentio\LaravelBase\Illuminate\Validation;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator as BaseValidator;

class Validator extends BaseValidator
{
    protected function getAttributeFromTranslations($name): ?string
    {
        $default = Arr::get($this->translator->get('validation.attributes'), $name);
        if ($default !== null) {
            return $default;
        }

        $parts = explode('.', $name, 2);
        if (count($parts) === 2) {
            $parts[0] = Str::pluralStudly($parts[0]);

            $phrased = Arr::get($this->translator->get($parts[0] . '.attributes'), $parts[1]);
            if ($phrased !== null) {
                return $phrased;
            }

            $name = $parts[1];
        }

        return str_replace('_', ' ', str_replace('.', ' ', Str::snake($name)));
    }
}