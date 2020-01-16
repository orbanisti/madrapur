<?php

    use yii\web\View;

    return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'components' => [

        'assetManager'=>[    'bundles' => [

            'yii\bootstrap\BootstrapAsset' => [
                'sourcePath'=>'@npm/bootstrap/dist',

                'css' => [

                    YII_ENV_DEV ? 'css/bootstrap.min.css' : 'css/bootstrap.min.css',

                ],

            ],

            'yii\bootstrap\BootstrapPluginAsset' => [
                'sourcePath'=>'@npm/bootstrap/dist',
                'js' => [


                ],
                'jsOptions' => [
                    'position' => View::POS_END
                ]

            ],


            'yii\web\JqueryAsset' => [

                'js' => [

                    YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'

                ]

            ],

        ],

        ],

        'urlManager' => require __DIR__ . '/_urlManager.php',
        'frontendCache' => require Yii::getAlias('@frontend/config/_cache.php')
    ],

    'params' => [
        'icon-framework' => \kartik\icons\Icon::FAS,  // Font Awesome Icon framework
        'bsDependencyEnabled' => true,
        'bsVersion' => '4.x', // this will set globally `bsVersion` to Bootstrap 4.x for all Krajee Extensions
        // other settings
        // 'adminEmail' => 'admin@example.com'
    ]
];
