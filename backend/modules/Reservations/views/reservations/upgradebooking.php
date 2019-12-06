<?php

    use backend\modules\Product\models\Product;
    use backend\modules\Reservations\models\Reservations;
    use kartik\detail\DetailView;
    use kartik\select2\Select2;
    use kartik\widgets\ActiveForm;
    use yii\helpers\Html;

?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                    Upgrade Booking
                </h3>

                <div class="card-tools">
<!--                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>-->
<!--                    </button>-->

                </div>
            </div>
            <div class="btn- card-body">
                <?php
                    $model=new Reservations();

                    if(!Yii::$app->request->isPost){
                        $form = ActiveForm::begin();
                        echo $form->field($model, 'ticketId')->textInput(['maxlength' => 255]);
                        echo $form->field($model, 'billing_first_name')->widget(Select2::classname(), [
                            'data' => $data,
                            'options' => ['placeholder' => 'Select a state ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);

                        echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']);
                    }
                    $reservationId=Yii::$app->request->get('id');
                    $ticketId=Yii::$app->request->post('Reservations')['ticketId'];
                    $billing_first_name=Yii::$app->request->post('Reservations')['billing_first_name'];
                    if(!$ticketId){
                        $ticketId=$billing_first_name;
                    }

                    if($ticketId) {

                        $model=Reservations::find()->andFilterWhere(['=','ticketId',$ticketId])->one();

                        echo Html::a('<i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>Upgrade Booking(EUR)',
                                     'upgrade?id='.$model->id.'&currency=EUR', ['class' => 'btn btn-info btn-large',
                                                                       'style'=>'width:50%;',]);
                        echo Html::a('<i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>Upgrade Booking(HUF)',
                                     'upgrade?id='.$model->id.'&currency=HUF', ['class' => 'btn btn-info btn-large',
                                                                       'style'=>'width:50%;',]);
                        $addonIcons='';
                        $data=json_decode($model->data);
                        if(isset($data->addons)){

                            foreach($data->addons as $addonId)
                            {
                                $addon=\backend\modules\Product\models\AddOn::findOne($addonId);
                                $addonIcons.=' '.'<span class="badge-info badge-pill">'
                                    .$addon->icon.'</span>';

                            }


                        }
                        $settings = [
                            'model' => $model,
                            'condensed' => true,
                            'hover' => true,
                            'mode' => DetailView::MODE_VIEW,

                            'deleteOptions' => [ // your ajax delete parameters
                                                 'params' => ['id' => $model->id, 'kvdelete' => true],
                            ],

                            'attributes' => [
                                ['attribute' => 'sellerName'],
                                [
                                    'attribute' => 'billing_first_name',
                                    'label' => 'Name',

                                    'value'=> $model->billing_first_name.' '.$model->billing_last_name

                                ],
                                [
                                    'attribute' => 'invoiceDate',
                                ],
                                [
                                    'attribute' => 'productId',
                                    'value' => (Product::findOne($model->productId))->title,
                                    'label' => 'Product'
                                ],

                                [
                                    'attribute' => 'booking_start',
                                    'value' => substr($model->booking_start, 0, -3),

                                ],
                                [
                                    'attribute' => 'notes',
                                    'type' => DetailView::INPUT_TEXTAREA,
                                ],
                                [
                                    'attribute' => 'allPersons',
                                    'format' => ['raw'],
                                    'value'=>$model->allPersons.' '.$addonIcons
                                ],
                                [
                                    'attribute' => 'booking_cost',
                                    'type' => DetailView::INPUT_TEXTAREA,
                                    'columns' => [
                                        [
                                            'attribute' => 'booking_cost',
                                            'format' => 'html',
                                            'type' => DetailView::INPUT_TEXTAREA,
                                            'value' => $model->booking_cost . ' ' . '<span class="badge  badge-info">'.$model->order_currency.'</span>' . '<span class="badge  badge-warning">
' . $model->status . '</span>'

                                        ],
                                        [
                                            'attribute' => 'ticketId',
                                            'type' => DetailView::INPUT_TEXTAREA,
                                            'format' => 'html',
                                            'value' => Html::a(
                                                $model->ticketId, [
                                                '/Tickets/tickets/view-ticket',
                                                'id' => $model->ticketId,
                                                'blockId' => $model->ticketId,
                                            ]
                                            )
                                        ],
                                    ]
                                ],
                            ]
                        ];

                        //                    $settings['attributes'][]=['attribute'=>'status'];
                        //
                        //                    foreach(json_decode($model->data) as  $key=>$attribute){
                        //                        echo $key.json_encode($attribute);
                        //                    }

                        echo DetailView::widget($settings);
                    }
                if(!Yii::$app->request->isPost)ActiveForm::end();
                ?>

            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>