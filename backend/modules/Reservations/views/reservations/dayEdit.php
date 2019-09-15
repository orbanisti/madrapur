<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use backend\components\extra;
use backend\models\Product\Product;
use backend\modules\Reservations\models\Reservations;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kartik\helpers\Html;

$title = 'Bookings of ' . '<u>' . $currentProduct->title . '</u>' . ' on ' . $currentDay;/*
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
                return Yii::$app->controller->renderPartial('assignui', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true,]
        ,

        ['class' => EditableColumn::class,
            'attribute' => 'firstName',

            'label' => 'First Name',
            'refreshGrid' => true,

            'editableOptions' => function ($model, $key, $index) {
                return [
                    'formOptions' => [
                        'id' => 'gv1_' . $model->id . '_form_name',
                        'action' => \yii\helpers\Url::to(['/Product/product/editbook'])
                    ],
                    'options' => [
                        'id' => 'gv1_' . $model->id . '_name',
                    ],
                ];
            },
        ],
        ['class' => EditableColumn::class,
            'attribute' => 'lastName',
            'label' => 'Last Name',
            'refreshGrid' => true,
            'editableOptions' => ['formOptions' => ['action' => ['/Product/product/editbook']]],

        ],
        ['class' => EditableColumn::class,
            'attribute' => 'bookedChairsCount',
            'pageSummary' => true,
            'refreshGrid' => true,
            'editableOptions' => ['formOptions' => ['action' => ['/Product/product/editbook']]],

        ],
        ['class' => EditableColumn::class,
            'attribute' => 'bookingCost',
            'refreshGrid' => true,
            'editableOptions' => ['formOptions' => ['action' => ['/Product/product/editbook']]],

        ],
        ['class' => EditableColumn::class,
            'attribute' => 'orderCurrency',
            'refreshGrid' => true,
            'editableOptions' => ['formOptions' => ['action' => ['/Product/product/editbook']]],
        ],

        /*   'productId',*/
        ['class' => EditableColumn::class,
            'attribute' => 'sourceName',
            'refreshGrid' => true,
            'editableOptions' => ['formOptions' => ['action' => ['/Product/product/editbook']]],
        ],
        'sellerName',
        'invoiceDate',
        'bookingDate',
        [
            'label' => 'Edit Booking',
            'format' => 'html',
            'value' => function ($model) {
                return '<a href="/Reservations/reservations/bookingedit?id=' . $model->id . '">Edit' . '</a>';
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

                foreach ($timesHours as $time) {

                    echo "       <li class=\"nav-item\">
                        <a class=\"nav-link \" id=\"times-$i-tab\" data-toggle=\"tab\" href='#times-$i' role=\"tab\" aria-controls=\"times-$i\">$time</a>
                    </li>";

                    ++$i;
                    $allGrids[] = $gridColumns;
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

                foreach ($timesHours as $time) {

                    echo '<div class="tab-pane " id="times-' . $i . '" role="tabpanel" aria-labelledby="times-' . $i . '">';
                    $reservationModel = new Reservations();

                    $availableChairs = $currentProduct->capacity - $reservationModel->countTakenChairsOnDayTime($selectedDate, $sources, $time);

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
                            'attribute' => 'firstName',

                            'label' => 'First Name',
                            'refreshGrid' => true,

                            'editableOptions' => function ($model, $key, $index) {
                            $currentdate = Yii::$app->request->get('date');
                            $ctime = $model->booking_start;
                            $firstpart = str_replace(':', '_', $ctime);
                            $secondpart = str_replace(' ', '_', $firstpart);

                            return [
                                'formOptions' => [
                                    'id' => 'gv1_' . $model->id . '_form_name',
                                    'action' => \yii\helpers\Url::to(['/Product/product/editbook'])
                                ],
                                'options' => [
                                    'id' => 'gv1_' . $secondpart . '_' . $model->id . rand() % 10000,
                                ],
                            ];
                        },
                        ],
                        ['class' => EditableColumn::class,
                            'attribute' => 'lastName',
                            'label' => 'Last Name',
                            'refreshGrid' => true,

                            'editableOptions' => function ($model, $key, $index) {
                                $currentdate = Yii::$app->request->get('date');
                                $ctime = $model->booking_start;
                                $firstpart = str_replace(':', '_', $ctime);
                                $secondpart = str_replace(' ', '_', $firstpart);

                                return [
                                    'formOptions' => [
                                        'id' => 'gv1_' . $model->id . '_form_name',
                                        'action' => \yii\helpers\Url::to(['/Product/product/editbook'])
                                    ],
                                    'options' => [
                                        'id' => 'gv1_' . $secondpart . '_' . $model->id . rand() % 10000,
                                    ],
                                ];
                            },

                        ],
                        ['class' => EditableColumn::class,
                            'attribute' => 'bookedChairsCount',
                            'label'=>'Number of tickets',
                            'pageSummary' => true,
                            'refreshGrid' => true,
                            'editableOptions' => function ($model, $key, $index) {
                                $currentdate = Yii::$app->request->get('date');
                                $ctime = $model->booking_start;
                                $firstpart = str_replace(':', '_', $ctime);
                                $secondpart = str_replace(' ', '_', $firstpart);


                                return [
                                    'formOptions' => [
                                        'id' => 'gv1_' . $model->id . '_form_name',
                                        'action' => \yii\helpers\Url::to(['/Product/product/editbook'])
                                    ],
                                    'options' => [
                                        'id' => 'gv1_' . $secondpart . '_' . $model->id . rand() % 10000,
                                    ],
                                ];
                            },


                        ],

                        /*   'productId',*/
                        ['class' => EditableColumn::class,
                            'attribute' => 'sourceName',
                            'label'=>'Seller Group Name',
                            'refreshGrid' => true,
                            'editableOptions' => function ($model, $key, $index) {
                                $currentdate = Yii::$app->request->get('date');
                                $ctime = $model->booking_start;
                                $firstpart = str_replace(':', '_', $ctime);
                                $secondpart = str_replace(' ', '_', $firstpart);

                                return [
                                    'formOptions' => [
                                        'id' => 'gv1_' . $model->id . '_form_name',
                                        'action' => \yii\helpers\Url::to(['/Product/product/editbook'])
                                    ],
                                    'options' => [
                                        'id' => 'gv1_' . $secondpart . '_' . $model->id . rand() % 10000,
                                    ],
                                ];
                            },
                        ],
                        [
                            'attribute' => 'sellerName',
                            'format' => 'html',
                            'value' => function ($model) {
                                return $model->sellerName . "<br/>" .'<a class="badge bg-aqua ">'.$model->iSellerName.'</a>';
                            }
                        ],
//                        'invoiceDate',
//                        'bookingDate',
//                        [
//                            'label' => 'Edit Booking',
//                            'format' => 'html',
//                            'value' => function ($model) {
//                                return '<a href="/Reservations/reservations/bookingedit?id=' . $model->id . '">Edit' . '</a>';
//                            }
//                        ],

                    ];


                    // the GridView widget (you must use kartik\grid\GridView)
                    // this GridView is for a single $time
                    echo GridView::widget([

                        'dataProvider' => $allDataProviders[$time],
//                        'filterModel' => $searchModel,
                        'columns' => $gridColumns,
                        'layout' => $layout,
                        'pjax' => true,
                        'toolbar' => [
                            [
                                'content' =>
                                    Html::button('<i class="fa fa-plus"></i>', [
                                        'class' => 'fa fa-ticket btn btn-outline-secondary',
                                        'title' => Yii::t('kvgrid', 'Add Book'),
                                        'onclick' => 'alert("This will launch new booking creation!");'
                                    ]) . ' ' .
                                    Html::a('<i class="fas fa-redo"></i>', ['grid-demo'], [
                                        'class' => 'btn btn-outline-secondary',
                                        'title' => Yii::t('kvgrid', 'Reset Grid'),
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
                        'striped' => true,
                        'panel' => [
                            'heading' => "<i class=\"fa fa-ticket\"></i>$title<a class=\"btn btn-success\">$time</a>",
                            'logo' => 'fa fa-ticket',
                            'footer' => "
                            <h3>Total capacity left for <a class=\"btn btn-success\">$time</a>: $availableChairs</br></h3>
                            <!--h4>Total places bought for this day: $takenChairsCount</br></h4-->
                            <h5>Total capacity for this product: $currentProduct->capacity</br></h5>
                ",
                        ],

                    ]);

                    echo '</div>';

                    ++$i;
                }
                echo '<div class="tab-pane active" id="times-all" role="tabpanel" aria-labelledby="times-all">';


                //this is whole days grid

                    echo "  <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css\">
  ";
                    ?>
                    <script>
                        $('.activity-view-link').click(function() {
                            var elementId = $(this).closest('tr').data('key');
                        }
                    </script>


                <?php

                echo GridView::widget([
                    'id' => 'wholeday',
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'layout' => $layout,
                    'pjax' => true,
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-all']],
                    'toolbar' => [
                        [
                            'content' =>
                                Html::button('<i class="fa fa-ticket fa-1x"></i><i class="fa fa-plus fa-1x"></i>', [
                                    'class' => ' btn btn-outline-secondary activity-view-link',
                                    'title' => Yii::t('kvgrid', 'Add Book'),
                                    'onclick' => 'alert("This will launch new booking creation!");',
                                ]) ,

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
                    'striped' => true,
                    'panel' => [
                        'heading' => '<i class="fa fa-ticket"></i>' . $title . ' ',
                        'logo' => 'fa fa-ticket',
                        'footer' => "
   
                ",
                    ],

                ]);

                echo '</div>';

                ?>

            </div>
        </div>


    </div>

</div>



