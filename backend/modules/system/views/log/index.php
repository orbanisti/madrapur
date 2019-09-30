<?php

use trntv\yii\datetime\DateTimeWidget;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 *
 * @var $this yii\web\View
 * @var $searchModel backend\modules\system\models\search\SystemLogSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('backend', 'System Logs');

$this->params['breadcrumbs'][] = $this->title;

?>

<p>
    <?php echo Html::a(Yii::t('backend', 'Clear'), false, ['class' => 'btn btn-danger', 'data-method' => 'delete']) ?>
</p>

<?php

echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive',
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            [
                'attribute' => 'level',
                'value' => function ($model) {
                    return \yii\log\Logger::getLevelName($model->level);
                },
                'filter' => [
                    \yii\log\Logger::LEVEL_ERROR => 'error',
                    \yii\log\Logger::LEVEL_WARNING => 'warning',
                    \yii\log\Logger::LEVEL_INFO => 'info',
                    \yii\log\Logger::LEVEL_TRACE => 'trace',
                    \yii\log\Logger::LEVEL_PROFILE_BEGIN => 'profile begin',
                    \yii\log\Logger::LEVEL_PROFILE_END => 'profile end',
                ],
            ],
            'category',
            'prefix',
            [
                'attribute' => 'log_time',
                'format' => 'datetime',
                'value' => function ($model) {
                    return (int)$model->log_time;
                },
                'filter' => DateTimeWidget::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'log_time',
                        'phpDatetimeFormat' => 'dd.MM.yyyy',
                        'momentDatetimeFormat' => 'DD.MM.YYYY',
                        'clientEvents' => [
                            'dp.change' => new JsExpression(
                                '(e) => $(e.target).find("input").trigger("change.yiiGridView")'),
                        ],
                    ]),
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'delete' => function ($url, $searchModel, $key) {
                        return Html::a(
                            '<span class="fa fa-lg fa-trash"></span>',
                            Url::to([
                                '/system/log/delete',
                                'id' => $searchModel->id,
                            ]),
                            [
                                'title' => Yii::t('app', 'Delete'),
                                'data-pjax' => '1',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete?'),
                                    'pjax' => 1,
                                ],
                            ]
                        );

                    },
                    'view' => function ($url, $searchModel, $key) {
                        return Html::a(
                            '<span class="fa fa-lg fa-pencil-alt"></span>',
                            Url::to([
                                '/system/log/view',
                                'id' => $searchModel->id,
                            ]),
                            [
                                'title' => Yii::t('app', 'View'),
                            ]
                        );
                    },
                ]
            ],
        ],
    ]);
?>
