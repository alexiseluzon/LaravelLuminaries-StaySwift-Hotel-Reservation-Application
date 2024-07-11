<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | Here you may define the base URL for your application. This will be used
    | to generate the URLs for your application's routes. You should set
    | this to the root of your application so that all URLs are generated
    | correctly.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Route Middleware
    |--------------------------------------------------------------------------
    |
    | Here you can define which middleware Ziggy will use to protect routes.
    | You can set this to null if you want to use Ziggy without any route
    | middleware or you can set it to an array of middleware names.
    |
    */

    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Excluded Routes
    |--------------------------------------------------------------------------
    |
    | Here you can define which routes should be excluded from Ziggy's route
    | generation. You can provide an array of route names or patterns, and
    | Ziggy will not generate these routes for use in your JavaScript.
    |
    */

    'except' => [
        // 'debugbar.*',
        // 'horizon.*',
    ],

    /*
    |--------------------------------------------------------------------------
    | Only Routes
    |--------------------------------------------------------------------------
    |
    | Here you can define which routes should be included in Ziggy's route
    | generation. If you want to generate only specific routes, you can
    | provide an array of route names or patterns, and Ziggy will generate
    | only these routes for use in your JavaScript.
    |
    */

    'only' => [
        // 'home',
        // 'api.*',
    ],

    /*
    |--------------------------------------------------------------------------
    | Named Routes
    |--------------------------------------------------------------------------
    |
    | Here you can define aliases for your named routes. You can use these
    | aliases in your JavaScript instead of the full route name. This can
    | make your code cleaner and easier to read.
    |
    */

    'aliases' => [
        // 'login' => 'auth.login',
    ],

    /*
    |--------------------------------------------------------------------------
    | Included Routes
    |--------------------------------------------------------------------------
    |
    | Here you can define which routes should be included in Ziggy's route
    | generation. If you want to generate only specific routes, you can
    | provide an array of route names or patterns, and Ziggy will generate
    | only these routes for use in your JavaScript.
    |
    */

    'include' => ['items.*', 'borrowed-items.*'],
];
