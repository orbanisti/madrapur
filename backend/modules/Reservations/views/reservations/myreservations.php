<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use backend\modules\Reservations\models\Reservations;
use backend\modules\Reservations\models\ReservationsAdminSearchModel;
use insolita\wgadminlte\LteBox;
use insolita\wgadminlte\LteConst;
use insolita\wgadminlte\LteInfoBox;
use insolita\wgadminlte\LteSmallBox;
use kartik\grid\GridView;
use kartik\helpers\Html;
use backend\components\extra;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;


?>

<!--suppress ALL -->
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-xs-12 col-md-3">
            <?php
                LteInfoBox::begin([
                    'bgIconColor' => LteConst::COLOR_AQUA,
                    'bgColor' => '',
                    'number' => $monthlySold,
                    'text'=>'EUR',
                    'icon'=>'fa fa-list-alt',
                    'showProgress' => true,
                    'progressNumber'=>100,
                    'description'=>'Monthly sold'
            ])?>
            <?php LteInfoBox::end()?>
        </div>
        <div class="col-xs-12 col-md-3">
            <?php
            LteInfoBox::begin([
                'bgIconColor' => LteConst::COLOR_BLUE,
                'bgColor' => '',
                'number' => $todaySold,
                'text'=>'EUR',
                'icon'=>'fa fa-list-alt',
                'showProgress' => true,
                'progressNumber'=>100,
                'description'=>'Today sold'
            ])?>
            <?php LteInfoBox::end()?>
        </div>
        <div class="col-xs-12 col-md-3">
            <?php
            LteInfoBox::begin([
                'bgIconColor' => LteConst::COLOR_OLIVE,
                'bgColor' => '',
                'number' => "Batthyány tér",
                'text'=>' ',
                'icon'=>'fa fa-map-marker',
                'showProgress' => true,
                'progressNumber'=>100,
                'description'=>'Current assigned location'
            ])?>
            <?php LteInfoBox::end()?>
        </div>
        <div class="col-xs-12 col-md-3">
            <?php
            LteInfoBox::begin([
                'bgIconColor' => LteConst::COLOR_TEAL,
                'bgColor' => '',
                'number' => "unset",
                'text'=>' ',
                'icon'=>'fa fa-ticket',
                'showProgress' => true,
                'progressNumber'=>100,
                'description'=>'Next ticked ID'
            ])?>
            <?php LteInfoBox::end()?>
        </div>
    </div>
    <?php
    $gridColumns = [
        'id',
        'updateDate',
       # 'bookingId',

        'bookedChairsCount',
       # 'source',
       # 'sellerName',
       # 'invoiceDate',

        'bookingCost',
        'orderCurrency',
       # 'bookingDate',
       /* [
            'label' => 'Edit Booking',
            'format'=>'html',
            'value' => function ($model) {
                return '<a href="/Reservations/reservations/bookingedit?id='.$model->returnId().'">Edit'.'</a>';
            }
        ],*/




    ];

    echo \kartik\grid\GridView::widget([



        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'pjax'=>true,
        'toolbar' =>  [
            [

                'options' => ['class' => 'btn-group mr-2']
            ],
            '{export}',
            '{toggleData}',
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        // set export properties
        'export' => [
            'fontAwesome' => true,

        ],
        'bordered' => true,
        'striped'=>true,
        'panel' => [
            'heading' => '<i class="fa fa-calendar"></i>',

        ],



    ]);


    ?>
</div>