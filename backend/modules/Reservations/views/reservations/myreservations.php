<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use backend\components\extra;
    use backend\modules\Product\models\Product;

    use kartik\dynagrid\DynaGrid;
    use kartik\grid\GridView;
    use kartik\helpers\Html;
    use kartik\icons\Icon;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Url;

?>

<!--suppress ALL -->
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-xs-12 col-md-3">

        </div>
        <div class="col-xs-12 col-md-3">

        </div> <div class="col-xs-12 col-md-3">

        </div>
        <div class="col-xs-12 col-md-3">
            <?php /*
            LteSmallBox::begin([
                'type' => Lte::COLOR_OLIVE,
                'title' => "Batthyány tér",
                'text' => 'Current assigned location',
                'icon' => 'fa fa-map-marker',
            ]) ?>
            <?php LteSmallBox::end() */?>
        </div>

    </div>
    <?php
        $gridColumns = [
            [
                'label' => 'Ticket Id',
                'attribute' => 'ticketId',

            ],
            [
                'label' => 'Product',
                'attribute' => 'productId',
                'format' => 'html',
                'value' => function ($model) {
                    return (Product::getProdById($model->productId))->title;
                },

            ],

            [
                'label' => 'Persons',
                'attribute' => 'bookedChairsCount',
                'format' => 'html',
                'value' => function ($model) {
                    $sellerBadge = '';
                    if (isset($model->iSellerName)) {

                        $sellerBadge = " <span class=\" badge bg-yellow\">" . $model->iSellerName . "</span>";
                    }

                    return $model->bookedChairsCount . ' ' . Icon::show(
                            'users', [
                                       'class' => 'fa-lg', 'framework'
                                       => Icon::FA
                                   ]
                        ) . $sellerBadge;
                }
            ],
            [
                'label' => 'Cost',
                'attribute' => 'bookingCost',

                'format' => 'html',
                'value' => function ($model) {

                    if ($model->order_currency == 'EUR') {
                        $currencySymbol = '<i class="fas fa-euro-sign  "></i>';
                    } else {
                        $currencySymbol = 'Ft';
                    }
                    if ($model->status == 'unpaid') {
                        $currencySymbol .= '<span class="badge badge-pill badge-warning">unpaid</span>';
                    }
                    return $model->booking_cost . ' ' . $currencySymbol;
                },


            ],
            [
                'label' => 'Partner',
                'attribute' => 'sellerName',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->sellerName === Yii::$app->user->getIdentity()->username) {
                        return '';
                    }

                    return $model->sellerName;
                }

            ],
            [
                'label' => 'Paid Method',
                'attribute' => 'paidMethod',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->paidMethod;
                }
            ],
            [
                'label' => 'Notes',
                'attribute' => 'notes',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->notes;
                }
            ],
            [
                'label' => 'Invoice date',
                'attribute' => 'invoiceDate',

                'value' => function ($model) {
                    return $model->invoiceDate;
                },
                'filterType'=>GridView::FILTER_DATE,
                'format'=>'raw',
                'width'=>'170px',
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['format'=>'yyyy-mm-dd']
                ],

            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url,$model) {
                        return Html::a(
                            '<span class="fa fa-lg fa-pencil-alt"></span>',
                            Url::to([
                                        'reservations/view',

                                        'id'=>$model->id,

                                    ]),
                            [
                                'title' => Yii::t('app', 'Update'),
                                'data-pjax' => '0',
                                'data' => [
                                    'method' => 'post',
                                    'pjax' => 0,
                                ],
                            ]
                        );
                    },

                ],

            ],

        ];



        $dynagrid = DynaGrid::begin([
                                        'columns' => $gridColumns,
                                        'theme'=>'panel-info',
                                        'showPersonalize'=>true,
                                        'storage' => 'session',
                                        'gridOptions'=>[
                                            'dataProvider'=>$dataProvider,
                                            'filterModel'=>new \backend\modules\Reservations\models\Reservations(),
                                            'showPageSummary'=>true,
                                            'floatHeader'=>false,
                                            'pjax'=>true,
                                            'responsiveWrap'=>false,
                                            'panel'=>[
                                                'heading'=>'<h5 class="panel-title"><i class="fas fa-book"></i>  My Bookings</h5>',
                                                'before' =>  '<div style="padding-top: 7px;"><em> </em></div>',
                                                'after' => false
                                            ],
                                            'toolbar' =>  [

                                                ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
                                                '{export}',
                                                '{toggleData}',
                                            ]
                                        ],
                                        'options'=>['id'=>'dynagrid-1'] // a unique identifier is important
                                    ]);
        if (substr($dynagrid->theme, 0, 6) == 'simple') {
            $dynagrid->gridOptions['panel'] = false;
        }
        DynaGrid::end();

    ?>


</div>