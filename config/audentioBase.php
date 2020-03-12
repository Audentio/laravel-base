<?php

return [
    'modelGenerator' => [
        'base' => \Audentio\LaravelBase\Foundation\AbstractModel::class,
        'namespaceTemplate' => '{{RootNamespace}}\Models',
    ],

    'controllerGenerator' => [
        'base' => \Audentio\LaravelBase\Foundation\AbstractController::class,
    ],
];