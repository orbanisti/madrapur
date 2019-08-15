<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use backend\modules\Reservations\models\Reservations;
use kartik\helpers\Html;
use backend\components\extra;
use yii\widgets\ActiveForm;
use kartik\grid\EditableColumn;
use backend\models\Product\Product;



$title ='Bookings of '.'<u>'.$currentProduct->title.'</u>'.' on '.$currentDay;/*
$this->title=$title;
$this->params['breadcrumbs'][] = $this->title;

*/


?>

<!--suppress ALL -->
<?php


echo \insolita\wgadminlte\FlashAlerts::widget([
    'errorIcon' => '<i class="fa fa-warning"></i>',
    'successIcon' => '<i class="fa fa-check"></i>',
    'successTitle' => 'Done!', //for non-titled type like 'success-first'
    'closable' => true,
    'encode' => false,
    'bold' => false,
]);
?>

<div class="products-index">


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
                return Yii::$app->controller->renderPartial('assingui', ['model' => $model]);
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
                'pageSummary' => true,
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
            'sellerName',
            'invoiceDate',
            'bookingDate',
            [
                'label' => 'Edit Booking',
                'format'=>'html',
                'value' => function ($model) {
                    return '<a href="/Reservations/reservations/bookingedit?id='.$model->id.'">Edit'.'</a>';
                }
            ],

        ];


        // the GridView widget (you must use kartik\grid\GridView)
        $layout = <<< HTML
<div class="float-right">
    <span style="color:red">{summary}</span>
</div>
{custom}
<div class="clearfix"></div>
{items}
{pager}
HTML;

        ?>


    <div class="panel panel-2">
        <div class="panel-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <?php
                $i = 0;


                foreach($timesHours as $time){

                     echo "       <li class=\"nav-item\">
                        <a class=\"nav-link \" id=\"times-$i-tab\" data-toggle=\"tab\" href='#times-$i' role=\"tab\" aria-controls=\"times-$i\">$time</a>
                    </li>";

                    ++$i;
                }
                echo "       <li class=\"nav-item active\">
                        <a class=\"nav-link \" id=\"times-all-tab\" data-toggle=\"tab\" href='#times-all' role=\"tab\" aria-controls=\"times-all\">Whole Day</a>
                    </li>";

                ?>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <?php
                $i = 0;



                foreach($timesHours as $time){

                    echo '<div class="tab-pane " id="times-'.$i.'" role="tabpanel" aria-labelledby="times-'.$i.'">';
                    $reservationModel=new Reservations();

                    $availableChairs=$reservationModel->countTakenChairsOnDayTime($selectedDate,$sources,$time);;


                // the GridView widget (you must use kartik\grid\GridView)

                echo \kartik\grid\GridView::widget([
                    'id' => 'times'.$time,
                    'dataProvider'=>$allDataProviders[$time],
                    'filterModel'=>$searchModel,
                    'columns'=>$gridColumns,
                    'layout' => $layout,
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
                        'heading' => "<i class=\"fa fa-ticket\"></i>$title<a class=\"btn btn-success\">$time</a>",
                        'logo'=>'fa fa-ticket',
                        'footer' => "
                            <h3>Total capacity left for this day: $availableChairs</br></h3>
                            <h4>Total places bought for this day: $takenChairsCount</br></h4>
                            <h5>Total capacity for this product: $currentProduct->capacity</br></h5>
                ",
                    ],




                ]);










                    echo '</div>';

                ++$i;
                }
                echo '<div class="tab-pane active" id="times-all" role="tabpanel" aria-labelledby="times-all">';
                echo \kartik\grid\GridView::widget([
                        'id'=>'wholeday',
                    'dataProvider'=>$dataProvider,
                    'filterModel'=>$searchModel,
                    'columns'=>$gridColumns,
                    'layout' => $layout,
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
                        'heading' => '<i class="fa fa-ticket"></i>'.$title.' ',
                        'logo'=>'fa fa-ticket',
                        'footer' => "
                            <h3>Total capacity left for this day: $availableChairs</br></h3>
                            <h4>Total places bought for this day: $takenChairsCount</br></h4>
                            <h5>Total capacity for this product: $currentProduct->capacity</br></h5>
                ",
                    ],




                ]);

                echo '</div>';

                ?>

            </div>
        </div>


    </div>

</div>



