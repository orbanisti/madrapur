<?php

/* @var $this yii\web\View */

/* @var $model backend\modules\Products\models\Products */

$this->title = Yii::t('app', 'Edit product') . '<br><u>' . $model->title . '</u>';

//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Termékek'), 'url' => ['admin']];
//$this->params['breadcrumbs'][] = Yii::t('app', 'Szerkesztés');

?>


<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-pencil-alt  "></i>
                    <?=Yii::t('app', 'Termék szerkesztése') . ' <u>' . $model->title . '</u>'?>
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">
                <div class="products-update">


                    <h1><?= $this->title ?></h1>

                    <?php

                        switch ($updateResponse) {
                            case 1:
                                $updateResponse = '<span style="color:green">Product Update Successful</span>';
                                break;
                            case 0:
                                $updateResponse = '<span style="color:red">Product Update Failed</span>';
                        }
                        echo $updateResponse;
                    ?>
                    <?php

                    $referrer = Yii::$app->request->referrer;

                    echo \yii\helpers\Html::a( 'Back', $referrer, [
                        'class' => "btn btn-primary" . ($referrer ? "" : " disabled"),
                    ]);
                    
                    ?>

                    <?=

                        $this->render('editForm', [
                            'model' => $model,
                            'backenddata' => $backendData,
                            'prodId' => $prodId,
                            'modelTimes' => $modelTimes,
                            'modelPrices' => $modelPrices,
                            'modelEvents' => $modelEvents,
                            'modelSources' => $modelSources,

                            /*
                                    'modelTranslations' => $modelTranslations,

                                    'modelPrices' => $modelPrices,
                                    'modelTimes' => $modelTimes

                            */
                        ]) ?>


                </div>
               
            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>   
 
    <!-- /.col -->
</div>

