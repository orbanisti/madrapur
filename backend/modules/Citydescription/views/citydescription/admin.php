<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\helpers\Html;
use backend\components\extra;
use backend\modules\Citydescription\models\Countries;
use kartik\select2\Select2;
use kartik\editable\Editable;

$this->title = Yii::t('app', 'Városok');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="citydescription-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Új város'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php

$gridColumns = [
   ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
            'attribute' => 'content',
                'format' => 'raw',
                'value' => function ($model) {
                    return extra::getIntro($model->content,150);
                },
            ],
            ['attribute' => 'country_id',
                'value' => function ($model) {
                        return (!empty($model->country))?$model->country->country_name:Yii::t('app','Nincs megadva');
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'country_id',
                    'data' => Countries::getList(),
                    'language' => 'hu',
                    'options' => ['placeholder' => 'Ország...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]),
            ],
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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            Yii::$app->urlManager->createAbsoluteUrl(['/../citydescription/citydescription/view', 'id'=>$model->id, 'title'=>$model->link]));
                    },
                    /*'link' => function ($url,$model,$key) {
                            return Html::a('Action', $url);
                    },*/
                ],
            ],
];

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
        ]
    ]);
    ?>
</div>

