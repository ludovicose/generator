<?php

return [
    'basePath' => app()->path('Module'),
    'rootNamespace' => 'App\\Module\\',
    'stubsOverridePath' => app()->path(),
    'paths' => [
        'models' => 'Models',
        'repositories' => 'Repositories/Eloquent',
        'queries' => 'Queries/Eloquent',
        'controllers' => 'Controllers/Api',
        'criteria' => 'Criteria/Eloquent',
        'services' => 'Services',
        'tests' => 'tests/Feature',
        'dto' => 'DTO',
        'request' => 'Requests',
        'policy' => 'Policies',
        'resource' => 'Resources',
        'providers' => 'Providers',
        'command' => 'Commands',
        'handler' => 'Handlers',
        'criteriaTrait' => 'Traits/Criteria',
        'serviceContract' => 'Contracts/Services',
        'repositoryContract' => 'Contracts/Repositories',
        'queryContract' => 'Contracts/Queries',
        'criteriaContract' => 'Contracts/Criteria',
    ],
];
