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



$this->title = Yii::t('app', 'Foglalások');
$this->params['breadcrumbs'][] = $this->title;



?>

<!--suppress ALL -->
<div class="products-index">



<div class="panel">
    <div class="panel-body">
    <?php
    $gridColumns = [
        'id',
        ['class' => EditableColumn::class,
            'attribute'=>'bookingId'],
        ['class' => EditableColumn::class,
        'attribute'=>'fname',

            ],
        ['class' => EditableColumn::class,
            'attribute'=>'lname',
        ],

        'productId',
        ['class' => EditableColumn::class,
            'attribute'=>'source',
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
        'pjax'=>true




    ]);


    ?>
    </div>
    </div>


    </div>


    <script>


    </script>

</div>