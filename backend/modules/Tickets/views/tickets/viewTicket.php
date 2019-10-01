<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use backend\components\extra;
use backend\models\Product\Product;

?>



<?php

    use kartik\detail\DetailView;

        $settings=
        [
                                'model'=>$model,
                                'condensed'=>true,
                                'hover'=>true,
                                'mode'=>DetailView::MODE_VIEW,
                                'panel'=>[
                                    'heading'=>'Ticket # ' . $model->ticketId,
                                    'type'=>DetailView::TYPE_INFO,
                                ],
                                'attributes'=>[
                                        ['attribute'=>'ticketId'],
                                        ['attribute'=>'sellerId'],
                                        ['attribute'=>'timestamp'],
                                        ['attribute'=>'reservationId'],
                                        ['attribute'=>'status'],

                                ]
    ];
    echo DetailView::widget($settings);



    ?>
