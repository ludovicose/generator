<?php

return [
    'basePath'          => app()->path('Module'),
    'rootNamespace'     => 'App\\Module\\',
    'stubCustomizePath' => app()->basePath('stubs/code/Stubs'),
    'paths'             => [
        'models'             => 'Models',
        'repositories'       => 'Repositories/Eloquent',
        'queries'            => 'Queries/Eloquent',
        'controllers'        => 'Controllers/Api',
        'services'           => 'Services',
        'tests'              => 'tests/Feature',
        'factories'          => 'database/factories',
        'dto'                => 'DTO',
        'request'            => 'Requests',
        'policy'             => 'Policies',
        'resource'           => 'Resources',
        'baseResource'       => 'app/Http/Resources',
        'providers'          => 'Providers',
        'router'             => 'routes/api',
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
