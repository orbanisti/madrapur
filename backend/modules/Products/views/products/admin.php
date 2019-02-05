<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\helpers\Html;
use yii\helpers\Url;
use backend\components\extra;
use \backend\modules\Products\models\Products;
use backend\modules\Products\models\Productscategory;
use backend\modules\Users\models\Users;
use kartik\select2\Select2;
use kartik\editable\Editable;
use backend\modules\Products\models\Graylinepartners;
use backend\modules\Users\Module as Usermodule;

$this->title = Yii::t('app', 'Termékek');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Termék létrehozása'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
        $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
            //'number',
            'name',
            /*['attribute' => 'intro',
                'format' => 'raw',
                'value' => function ($model) {
                    return extra::getIntro($model->intro);
                },
            ],*/
            /*['attribute' => 'description',
                'format' => 'raw',
                'value' => function ($model) {
                    return extra::getIntro($model->description);
                },
            ],*/
            /*['attribute' => 'user',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->user->username;
                },
            ],*/
            ['attribute' => 'country_id',
                'value' => function ($model) {
                        return (isset($model->country))?$model->country:'';
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'country_id',
                    //'data' => backend\modules\Citydescription\models\Countries::getList(),
                    'language' => 'hu',
                    'options' => ['placeholder' => 'Ország...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]),
            ],
            ['attribute' => 'city_id',
                'value' => function ($model) {
                        return (isset($model->city))?$model->city:'';
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'city_id',
                    //'data' => \backend\modules\Citydescription\models\Citydescription::getList(),
                    'language' => 'hu',
                    'options' => ['placeholder' => 'Város...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]),
            ],
            ['attribute' => 'user',
                'value' => function ($model) {
                        return $model->user->username;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'user',
                    //'data' => Users::getDropdownlist(),
                    'language' => 'hu',
                    'options' => ['placeholder' => 'Felhasználó...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]),
            ],
            ['attribute' => 'channel_id',
                'value' => function ($model) {
                        return (isset($model->graylinepartner))?$model->graylinepartner->name:'';
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'channel_id',
                    //'data' => Graylinepartners::getDropdownlist(),
                    'language' => 'hu',
                    'options' => ['placeholder' => 'Grayline partner...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]),
            ],
            ['attribute' => 'status',
                'value' => function ($model) {
                        return Products::status($model->status);
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', Products::status(),['class'=>'form-control','prompt' => '']),
            ],
            /*['attribute' => 'category_id',
                'value' => function ($model) {
                        return $model->category->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'category_id', Products::getDropdowncategoriestoadmin(),['class'=>'form-control','prompt' => '']),
            ],*/
            ['attribute' => 'source',
                'value' => function ($model) {
                        return Products::source($model->source);
                },
                'filter' => Html::activeDropDownList($searchModel, 'source', Products::source(),['class'=>'form-control','prompt' => '']),
            ],
            /*['attribute' => 'modified',
                'value' => function ($model) {
                        return Products::modified($model->modified);
                },
                'filter' => Html::activeDropDownList($searchModel, 'modified', Products::modified(),['class'=>'form-control','prompt' => '']),
            ],*/
            [   'label' => Yii::t('app', 'Szerződés'),
                'value' => function ($model) {
                        return Usermodule::contract($model->user->contract);
                },
                'filter' => Html::activeDropDownList($searchModel, 'contract', Usermodule::contract(),['class'=>'form-control','prompt' => '']),
            ],
            [
                'class'=>'kartik\grid\EditableColumn',
                'attribute'=>'partnercomment',
                'pageSummary'=>true,
                'value' => function ($model) {
                        return $model->user->comment;
                },
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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
    ];

    /* TODO EXPORT START
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
            #['content'=>
            #    Html::button('<i class="glyphicon glyphicon-plus"></i>', [
            #        'type'=>'button',
            #        'title'=>Yii::t('kvgrid', 'Add Book'),
            #        'class'=>'btn btn-success'
            #    ]) . ' '.
            #    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], [
            #        'data-pjax'=>0,
            #        'class' => 'btn btn-default',
            #        'title'=>Yii::t('kvgrid', 'Reset Grid')
            #    ])
            #],
        ]
    ]);

    TODO EXPORT END */
    ?>

</div>