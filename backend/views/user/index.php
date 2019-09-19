<?php
use common\grid\EnumColumn;
use common\models\User;
    use kartik\grid\GridView;
    use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\Html;

use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = Yii::t('backend', 'Users');
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
            <?=Yii::t('backend', 'Users')?>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>

        </div>
    </div>
    <div class="card-body">


        <div class="user-index">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?php

                    echo Html::a(Yii::t('backend', 'Create {modelClass}', [
                        'modelClass' => 'User',
                    ]), [
                        'create'
                    ], [
                        'class' => 'btn btn-info'
                    ])?>
            </p>

            <?php

                echo GridView::widget(
                    [
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'options' => [
                            'class' => 'grid-view table-responsive'
                        ],
                        'columns' => [
                            'id',
                            'username',
                            'email:email',
                            [
                                'class' => EnumColumn::class,
                                'attribute' => 'status',
                                'enum' => User::statuses(),
                                'filter' => User::statuses()
                            ],
                            [
                                'attribute' => 'created_at',
                                'format' => 'datetime',
                                'filter' => DateTimeWidget::widget(
                                    [
                                        'model' => $searchModel,
                                        'attribute' => 'created_at',
                                        'phpDatetimeFormat' => 'dd.MM.yyyy',
                                        'momentDatetimeFormat' => 'DD.MM.YYYY',
                                        'clientEvents' => [
                                            'dp.change' => new JsExpression(
                                                '(e) => $(e.target).find("input").trigger("change.yiiGridView")')
                                        ],
                                    ])
                            ],
                            [
                                'attribute' => 'logged_at',
                                'format' => 'datetime',
                                'filter' => DateTimeWidget::widget(
                                    [
                                        'model' => $searchModel,
                                        'attribute' => 'logged_at',
                                        'phpDatetimeFormat' => 'dd.MM.yyyy',
                                        'momentDatetimeFormat' => 'DD.MM.YYYY',
                                        'clientEvents' => [
                                            'dp.change' => new JsExpression(
                                                '(e) => $(e.target).find("input").trigger("change.yiiGridView")')
                                        ],
                                    ])
                            ],
                            // 'updated_at',

                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'template' => '{login} {view} {update} {delete}',
                                'buttons' => [
                                    'login' => function ($url) {
                                        return Html::a('<i class="fas fa-sign-in-alt  " aria-atomic="hidden"></i>',
                                                       $url,
                                            [
                                                'title' => Yii::t('backend', 'Login')
                                            ]);
                                    },
                                ],
                                'visibleButtons' => [
                                    'login' => Yii::$app->user->can('administrator')
                                ]
                            ],
                        ],
                    ]);
            ?>

        </div>
    </div>
    <!-- /.card-body-->
</div>


