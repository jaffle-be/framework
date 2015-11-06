<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | Default module namespace.
    |
    */

    'namespace' => 'Modules',

    /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
    */

    'stubs' => [
        'enabled' => true,
        'path' => base_path().'/vendor/pingpong/modules/Commands/stubs',
        'files' => [
            'start' => 'helpers.php',
            'routes' => 'Http/routes.php',
            'breadcrumbs' => 'Http/breadcrumbs.php',
            'json' => 'module.json',

            'controllers/front' => 'Http/Controllers/StubController.php',
            'controllers/admin' => 'Http/Controllers/Admin/StubController.php',

            'provider' => 'Providers/StubServiceProvider.php',

            'jobs/update' => 'Jobs/UpdateStub.php',

            'views/admin/overview' => 'resources/views/admin/overview.blade.php',
            'views/admin/detail' => 'resources/views/admin/detail.blade.php',
            'scaffold/config' => 'config/config.php',
            'composer' => 'composer.json',
            'js/admin/config' => 'resources/assets/js/admin/config.js',
            'js/admin/models' => 'resources/assets/js/admin/models.js',
            'js/admin/translations' => 'resources/assets/js/admin/translations.js',
            'js/admin/controllers/overview' => 'resources/assets/js/admin/controllers/OverviewController.js',
            'js/admin/controllers/detail' => 'resources/assets/js/admin/controllers/DetailController.js',
            'js/admin/services/service' => 'resources/assets/js/admin/services/Service.js',
        ]
    ],
    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated module. This path also will added
        | automatically to list of scanned folders.
        |
        */

        'modules' => base_path('modules'),
        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules assets path.
        |
        */

        'assets' => public_path('modules'),
        /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'module:publish-migration' command, where do you publish the
        | the migration files?
        |
        */

        'migration' => base_path('database/migrations'),
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules generator path.
        |
        */

        'generator' => [
            'config' => 'config',
            'migration' => 'database/migrations',
            'seeder' => 'database/seeders',
            'images' => 'database/images',
            'factories' => 'database/factories',
            'en' => 'resources/lang/en',
            'nl' => 'resources/lang/nl',
            'de' => 'resources/lang/de',
            'fr' => 'resources/lang/fr',
            'views' => 'resources/views',
            'jscontrollers' => 'resources/assets/js/admin/controllers',
            'jsdirectives' => 'resources/assets/js/admin/directives/',
            'jsservices' => 'resources/assets/js/admin/services/',
            'test' => 'tests',
            'command' => 'Console',
            'jobs' => 'Jobs',
            'presenter' => 'Presenter',
            'model' => 'Entities',
            'repository' => 'Repositories',
            'controller' => 'Http/Controllers',
            'filter' => 'Http/Middleware',
            'request' => 'Http/Requests',
            'provider' => 'Providers',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
    */

    'scan' => [
        'enabled' => false,
        'paths' => [
            base_path('vendor/*/*'),
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Composer File Template
    |--------------------------------------------------------------------------
    |
    | Here is the config for composer.json file, generated by this package
    | in every module since version >= 1.2.0.
    |
    */

    'composer' => [
        'vendor' => 'pingpong-modules',
        'author' => [
            'name' => 'Pingpong Labs',
            'email' => 'pingpong.labs@gmail.com',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
    */
    'cache' => [
        'enabled' => false,
        'key' => 'pingpong-modules',
        'lifetime' => 60,
    ],

];
