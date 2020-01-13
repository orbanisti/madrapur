<?php

    use backend\modules\Product\models\Product;
    use yii\web\View;

    $config = [
    'homeUrl' => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => [
        'maintenance'
    ],
    'modules' => [
        'user' => [
            'class' => frontend\modules\user\Module::class,
            'shouldBeActivated' => false,
            'enableLoginByPass' => false,
        ],
        'Reservations' => [
            'class' => frontend\modules\Reservations\Module::class,
        ],
    ],

    'components' => [
        'cart' => [
            'class' => 'devanych\cart\Cart',
            'storageClass' => 'devanych\cart\storage\SessionStorage',
            'calculatorClass' => 'devanych\cart\calculators\SimpleCalculator',
            'params' => [
                'key' => 'cart',
                'expire' => 604800,
                'productClass' => Product::class,
                'productFieldId' => 'id',
                'productFieldPrice' => 'price',
            ],
        ],
        'thumbnailer' => [
            'class' => 'daxslab\thumbnailer\Thumbnailer',
            'defaultWidth' => 500,
            'defaultHeight' => 500,
            'thumbnailsPath' => '@webroot/assets/thumbs',
            'thumbnailsBaseUrl' => '@web/assets/thumbs',
            'enableCaching' => true, //defaults to false but is recommended
        ],
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

                    YII_ENV_DEV ? 'js/bootstrap.bundle.js' : 'js/bootstrap.bundle.js',
                    'js/bootstrap.js'

                ],
                'jsOptions' => [
                    'position' => View::POS_HEAD
                ]

            ],


            'yii\web\JqueryAsset' => [

                'js' => [

                    YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'

                ]

            ],

        ],

        ],
        'authClientCollection' => [
            'class' => yii\authclient\Collection::class,
            'clients' => [
                'github' => [
                    'class' => yii\authclient\clients\GitHub::class,
                    'clientId' => env('GITHUB_CLIENT_ID'),
                    'clientSecret' => env('GITHUB_CLIENT_SECRET')
                ],
                'facebook' => [
                    'class' => yii\authclient\clients\Facebook::class,
                    'clientId' => env('FACEBOOK_CLIENT_ID'),
                    'clientSecret' => env('FACEBOOK_CLIENT_SECRET'),
                    'scope' => 'email,public_profile',
                    'attributeNames' => [
                        'name',
                        'email',
                        'first_name',
                        'last_name',
                    ]
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'maintenance' => [
            'class' => common\components\maintenance\Maintenance::class,
            'enabled' => function ($app) {
                if (env('APP_MAINTENANCE') === '1') {
                    return true;
                }
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'request' => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => [
                '/user/sign-in/login'
            ],
            'enableAutoLogin' => true,
            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class
        ],
    ]
];
    define("OTP", "../../simplepay/");
if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'generators' => [
            'crud' => [
                'class' => yii\gii\generators\crud\Generator::class,
                'messageCategory' => 'frontend'
            ]
        ]
    ];
}

return $config;
