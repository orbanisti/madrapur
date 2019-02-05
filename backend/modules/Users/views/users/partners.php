<?phpbackend\backend\backend\backend\

/*use yii\helpers\Html;
use yii\grid\GridView;*/
use app\modules\Users\Module as Usermodule;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\helpers\Html;
use yii\helpers\Url;
use kartik\editable\Editable;
use app\modules\Products\models\Products;

$this->title = Yii::t('app', 'Partnerek');
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    //['class' => 'kartik\grid\SerialColumn'],
            //'id',
            'email:email',
            'username',
            /*['attribute' => 'dividend',
                'value' => function ($model) {
                        return $model->dividend.'%';
                },
            ],*/
            ['attribute' => 'commission',
                'value' => function ($model) {
                        return $model->commission;
                },
            ],
            ['attribute' => 'commission_type',
                'value' => function ($model) {
                        return Products::commissiontypes($model->commission_type);
                },
                'filter' => Html::activeDropDownList($searchModel, 'commission_type', Products::commissiontypes(),['class'=>'form-control','prompt' => '']),
            ],
            ['attribute' => 'dividendprice',
                'label'=>'Összege',
                'format'=>'raw',
                'value' => function ($model) {
                        return app\models\Shopcurrency::priceFormat($model->dividendprice);
                },
            ],
            //'regdate',
            ['attribute' => 'status',
                'value' => function ($model) {
                        return Usermodule::status($model->status);
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', Usermodule::status(),['class'=>'form-control','prompt' => '']),
            ],
            ['attribute' => 'payment_in_advance',
                'value' => function ($model) {
                        return Usermodule::paymentad($model->payment_in_advance);
                },
                'filter' => Html::activeDropDownList($searchModel, 'payment_in_advance', Usermodule::paymentad(),['class'=>'form-control','prompt' => '']),
            ],
            /*['label' => 'Megjegyzés',
                'format' => 'raw',
                'attribute' => 'comment',
                'filterInputOptions' => ['class' => 'form-control', 'id' => 'message'],
                'content' => function ($model) {
                        return Editable::widget([
                            'model' => $model,
                            'attribute' => 'comment',
                            'type' => 'primary',
                            'size'=> 'lg',
                            'asPopover' => false,
                            'inputType' => Editable::INPUT_TEXTAREA,
                            'editableValueOptions' => ['class' => 'text-success h3']
                        ]);
                },
                'filter' => false,
            ],*/
            [
                'class'=>'kartik\grid\EditableColumn',
                'attribute'=>'comment',
                'pageSummary'=>true,
                'editableOptions'=> function ($model, $key, $index) {
                    return [
                        'header'=>'megjegyzés',
                        'size'=>'lg',
                        'inputType' => Editable::INPUT_TEXTAREA,
                        'submitOnEnter' => false,
                        'asPopover' => false,
                        'afterInput'=>function ($form, $widget) use ($model, $index) {
                            //return $form->field($model, "comment")->textarea();
                        }
                    ];
                },
            ],
        ['class' => 'kartik\grid\ActionColumn',
        //'dropdown' => true,
        'vAlign'=>'middle',
        'template' => '{tandc} {update} {delete}',
        'buttons' => [
            'tandc' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url, [
                            'title' => Yii::t('app','Felhasználási feltételek'),
                            'class'=>'',
                ]);
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            if ($action === 'update') {
                return Url::to(['/users/users/update', 'id'=>$model->id ]);
            } elseif ($action === 'tandc') {
                return Url::to(['/users/profile/termsconditionsuser', 'id'=>$model->id ]);
            } elseif ($action === 'delete') {
                return Url::to(['/users/users/delete', 'id'=>$model->id ]);
            }
        },
    ],
];
?>

<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?php
    $fullExportMenu = ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'target' => ExportMenu::TARGET_BLANK,
        'fontAwesome' => true,
        'pjaxContainerId' => 'kv-pjax-container',
        'dropdownOptions' => [
            'label' => 'Összes',
            'class' => 'btn btn-default',
            'itemsBefore' => [
                '<li class="dropdown-header">Összes exportálása</li>',
            ],
        ],
    ]);
    echo GridView::widget([
    'pager' => [
        'firstPageLabel' => Yii::t('app','Első oldal'),
        'lastPageLabel'  => Yii::t('app','Utolsó oldal'),
    ],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'pjax' => false,
    'responsive' => true,
    'hover' => true,
    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        //'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Magánszemélyek</h3>',
    ],
    // set a label for default menu
    'export' => [
        'label' => 'Oldal',
        'fontAwesome' => true,
    ],
    // your toolbar can include the additional full export menu
    'toolbar' => [
        '{toggleData}',
        '{export}',
        $fullExportMenu,
        /*['content'=>
            Html::button('<i class="glyphicon glyphicon-plus"></i>', [
                'type'=>'button',
                'title'=>Yii::t('kvgrid', 'Add Book'),
                'class'=>'btn btn-success'
            ]) . ' '.
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], [
                'data-pjax'=>0,
                'class' => 'btn btn-default',
                'title'=>Yii::t('kvgrid', 'Reset Grid')
            ])
        ],*/
    ]
]);
?>

    <?php /*echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'email:email',
            'username',
            ['attribute' => 'dividend',
                'value' => function ($model) {
                        return $model->dividend.'%';
                },
            ],
            ['attribute' => 'dividendprice',
                'format'=>'raw',
                'value' => function ($model) {
                        return app\models\Shopcurrency::priceFormat($model->dividendprice);
                },
            ],
            'regdate',
            ['attribute' => 'status',
                'value' => function ($model) {
                        return Usermodule::status($model->status);
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', Usermodule::status(),['class'=>'form-control','prompt' => '']),
            ],
            ['attribute' => 'payment_in_advance',
                'value' => function ($model) {
                        return Usermodule::paymentad($model->payment_in_advance);
                },
                'filter' => Html::activeDropDownList($searchModel, 'payment_in_advance', Usermodule::paymentad(),['class'=>'form-control','prompt' => '']),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}'
            ],
        ],
    ]);*/ ?>

</div>