<?php

namespace backend\modules\Payment;

use yii\filters\AccessControl;

/**
 * payment module definition class
 */
class Module extends \yii\base\Module {
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\Payment\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        // custom initialization code goes here
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['admin'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'admin'
                        ],
                        'roles' => ['officeAdmin']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['admin'],
                        'roles' => ['officeAdmin']
                    ],
                    [
                        'allow' => false
                    ]
                ],
            ],
        ];
    }
}
