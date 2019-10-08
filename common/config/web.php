<?php
$config = [
    'components' => [
        'assetManager' => [
            'class' => \common\base\MadAssetManager::class,
            'linkAssets' => env('LINK_ASSETS'),
            'appendTimestamp' => YII_ENV_DEV,
            'bundles' => [
                'wbraganca\dynamicform\DynamicFormAsset' => [
                    'sourcePath' => '@common/assets/overrides/js',
                    'js' => [
                        'yii2-dynamic-form.js'
                    ],
                ],
            ],
        ]
    ],
    'modules' => [
        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',

            // format settings for displaying each date attribute
            'displaySettings' => [
                'date' => 'd-m-Y',
                'time' => 'H:i:s A',
                'datetime' => 'd-m-Y H:i:s A',
            ],

            // format settings for saving each date attribute
            'saveSettings' => [
                'date' => 'Y-m-d',
                'time' => 'H:i:s',
                'datetime' => 'Y-m-d H:i:s',
            ],



            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,

        ]
    ],
    'as locale' => [
        'class' => common\behaviors\LocaleBehavior::class,
        'enablePreferredLanguage' => true
    ]
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
        'allowedIPs' => [
            '127.0.0.1',
            '::1',
            '192.168.33.1',
            '172.17.42.1',
            '172.17.0.1',
            '192.168.99.1'
        ],
    ];
}

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'allowedIPs' => [
            '127.0.0.1',
            '::1',
            '192.168.33.1',
            '172.17.42.1',
            '172.17.0.1',
            '192.168.99.1'
        ],
    ];
}

return $config;
