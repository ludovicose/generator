<?php

return [
    'basePath'          => app()->path('Module'),
    'rootNamespace'     => 'App\\Module\\',
    'stubsOverridePath' => app()->path(),
    'paths'             => [
        'models'             => 'Models',
        'repositories'       => 'Repositories/Eloquent',
        'queries'            => 'Queries/Eloquent',
        'controllers'        => 'Controllers/Api',
        'services'           => 'Services',
        'tests'              => 'tests/Feature',
        'dto'                => 'DTO',
        'request'            => 'Requests',
        'policy'             => 'Policies',
        'resource'           => 'Resources',
        'baseResource'       => 'app/Http/Resources',
        'providers'          => 'Providers',
        'router'             => 'routes',
        'command'            => 'Commands',
        'handler'            => 'Handlers',
        'serviceContract'    => 'Contracts/Services',
        'repositoryContract' => 'Contracts/Repositories',
        'queryContract'      => 'Contracts/Queries',
    ],
    'files'             => [
        'routeServiceProviderPath' => 'app/Providers/RouteServiceProvider.php'
    ]
];
