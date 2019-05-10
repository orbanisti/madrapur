<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use kartik\helpers\Html;
use backend\components\extra;
use yii\widgets\ActiveForm;
use kartik\grid\EditableColumn;
use backend\models\Product\Product;



$title ='Bookings of '.'<u>'.$currentProduct->title.'</u>'.' on '.$currentDay;
$this->params['breadcrumbs'][] = $this->title;




?>

<!--suppress ALL -->
<div class="products-index">



<div class="panel">
    <div class="panel-body">
    <?php
    $gridColumns = [
      /*  'id',
        ['class' => EditableColumn::class,
            'attribute'=>'bookingId'],*/
        ['class' => 'kartik\grid\ExpandRowColumn',
        'width' => '50px',
        'value' => function ($model, $key, $index, $column) {
            return \kartik\grid\GridView::ROW_COLLAPSED;
        },
        // uncomment below and comment detail if you need to render via ajax
        // 'detailUrl'=>Url::to(['/site/book-details']),
        'detail' => function ($model, $key, $index, $column) {
            return Yii::$app->controller->renderPartial('reservationInfo', ['model' => $model]);
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'expandOneOnly' => true,]
        ,

        ['class' => EditableColumn::class,
            'attribute'=>'firstName',

            'label'=>'First Name',
            'refreshGrid'=>true,

            'editableOptions'=> ['formOptions' => ['action' => ['/Product/product/editbook']]],
        ],
        ['class' => EditableColumn::class,
            'attribute'=>'lastName',

            'label'=>'Last Name',
            'refreshGrid'=>true,

            'editableOptions'=> ['formOptions' => ['action' => ['/Product/product/editbook']]],

        ],
        ['class' => EditableColumn::class,
            'attribute'=>'bookedChairsCount',
            'refreshGrid'=>true,

            'editableOptions'=> ['formOptions' => ['action' => ['/Product/product/editbook']]],

        ],
        ['class' => EditableColumn::class,
            'attribute'=>'bookingCost',
            'refreshGrid'=>true,

            'editableOptions'=> ['formOptions' => ['action' => ['/Product/product/editbook']]],

        ],
        ['class' => EditableColumn::class,
            'attribute'=>'orderCurrency',
            'refreshGrid'=>true,
            'editableOptions'=> ['formOptions' => ['action' => ['/Product/product/editbook']]],

        ],



        /*   'productId',*/
                ['class' => EditableColumn::class,
                    'attribute'=>'sourceName',
                    'refreshGrid'=>true,

                    'editableOptions'=> ['formOptions' => ['action' => ['/Product/product/editbook']]],



                   ],
        'invoiceDate',
        'bookingDate',
        [
            'label' => 'Edit Booking',
            'format'=>'html',
            'value' => function ($model) {
                return '<a href="/Reservations/reservations/bookingedit?bookingId='.$model->returnBookingId().'">Edit'.'</a>';
            }
        ],

    ];


    // the GridView widget (you must use kartik\grid\GridView)
    echo \kartik\grid\GridView::widget([
        'dataProvider'=>$dataProvider,
        'filterModel'=>$searchModel,
        'columns'=>$gridColumns,
        'pjax'=>true,
        'toolbar' =>  [
            [
                'content' =>
                    Html::button('<i class="fas fa-plus"></i>', [
                        'class' => 'fa fa-ticket',
                        'title' => Yii::t('kvgrid', 'Add Book'),
                        'onclick' => 'alert("This will launch new booking creation!");'
                    ]) . ' '.
                    Html::a('<i class="fas fa-redo"></i>', ['grid-demo'], [
                        'class' => 'btn btn-outline-secondary',
                        'title'=>Yii::t('kvgrid', 'Reset Grid'),
                        'data-pjax' => 0,
                    ]),
                'options' => ['class' => 'btn-group mr-2']
            ],
            '{export}',
            '{toggleData}',
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        // set export properties
        'export' => [
            'fontAwesome' => true
        ],
        'bordered' => true,
        'striped'=>true,
        'panel' => [
            'heading' => '<i class="fa fa-ticket"></i>'.$title,
            'logo'=>'fa fa-ticket'
        ],




    ]);


    ?>
    </div>
    <div class="panel">
        <div class="panel-heading">
            <h3>Total capacity left for this day: <?=$availableChairs?></br></h3>
            <h4>Total places bought for this day: <?=$takenChairsCount?></br></h4>
            <h5>Total capacity for this product:<?=$currentProduct->capacity?></br></h5>


        </div>
        <div class="panel-body">

        </div>

    </div>
    </div>








</div>