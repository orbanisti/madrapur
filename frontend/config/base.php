<?php
return [
    'id' => 'frontend',
    'basePath' => dirname(__DIR__),
    'components' => [
        'urlManager' => require (__DIR__ . '/_urlManager.php'),
        'cache' => require (__DIR__ . '/_cache.php'),
    ],
    'params' => [
        'icon-framework' => \kartik\icons\Icon::FAS,  // Font Awesome Icon framework
        'bsDependencyEnabled' => true,
        'bsVersion' => '4.x', // this will set globally `bsVersion` to Bootstrap 4.x for all Krajee Extensions
        // other settings
        // 'adminEmail' => 'admin@example.com'
    ]
];
