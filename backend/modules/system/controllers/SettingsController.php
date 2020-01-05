<?php

    namespace backend\modules\system\controllers;

    use common\components\keyStorage\FormModel;
    use Yii;
    use yii\web\Controller;

    class SettingsController extends Controller {

        public function actionIndex() {

            $allOptions = [
                'keys' => [
                    'frontend.maintenance' => [
                        'label' => Yii::t('backend', 'Frontend maintenance mode'),
                        'type' => FormModel::TYPE_DROPDOWN,
                        'items' => [
                            'disabled' => Yii::t('backend', 'Disabled'),
                            'enabled' => Yii::t('backend', 'Enabled'),
                        ],
                    ],
                    'backend.theme-skin' => [
                        'label' => Yii::t('backend', 'Backend theme'),
                        'type' => FormModel::TYPE_DROPDOWN,
                        'items' => [
                            'skin-black' => 'skin-black',
                            'skin-blue' => 'skin-blue',
                            'skin-green' => 'skin-green',
                            'skin-purple' => 'skin-purple',
                            'skin-red' => 'skin-red',
                            'skin-yellow' => 'skin-yellow',
                        ],
                    ],
                    'backend.layout-fixed' => [
                        'label' => Yii::t('backend', 'Fixed backend layout'),
                        'type' => FormModel::TYPE_CHECKBOX,
                    ],
                    'backend.layout-boxed' => [
                        'label' => Yii::t('backend', 'Boxed backend layout'),
                        'type' => FormModel::TYPE_CHECKBOX,
                    ],
                    'backend.layout-collapsed-sidebar' => [
                        'label' => Yii::t('backend', 'Backend sidebar collapsed'),
                        'type' => FormModel::TYPE_CHECKBOX,
                    ],

                ],
            ];
            if (Yii::$app->user->can('administrator')) {
                $adminOptions = ['currency.huf-value' => [
                    'label' => Yii::t('backend', 'Value of 1 EUR in HUF'),

                ], 'currency.USD-value' => [
                    'label' => Yii::t('backend', 'Value of 1 EUR in USD'),

                ],
                     'paypal.email' => [
                         'label' => Yii::t('backend', 'This is the Email where Paypal may be sent'),

                     ],
                     'simplePay.eur' => [
                         'label' => Yii::t('backend', 'This is the Id of EUR Simplepay merchant'),

                     ],
                     'onesignal.appId' => [
                         'label' => Yii::t('backend', 'This is the oneSignal appId'),

                     ],
                     'onesignal.apiKey' => [
                         'label' => Yii::t('backend', 'This is the oneSignal apiKey'),

                     ],
                    ];
                $allOptions;
                foreach ($adminOptions as $key => $option) {
                    $allOptions['keys'][$key] = $option;
                }
            }

            $model = new FormModel($allOptions
            );

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('alert',
                    [
                        'body' => Yii::t('backend', 'Settings was successfully saved'),
                        'options' => [
                            'class' => 'alert alert-success'
                        ],
                    ]);

                return $this->refresh();
            }

            return $this->render('index', [
                'model' => $model
            ]);
        }
    }