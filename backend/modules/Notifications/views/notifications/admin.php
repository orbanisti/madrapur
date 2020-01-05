<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-dark ">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa fa-bell fa-fw" aria-hidden="true"></i>Notifications
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn  btn-tool" data-card-widget="collapse"><i class="fas
                    fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class=" card-body bg-gradient-gray-dark">
                <p>Hello, <strong><?=Yii::$app->user->getIdentity()->username?></strong></p>

                <?php use yii\helpers\Html;
                        \frontend\assets\MdbButtonsAsset::register($this);
                    echo Html::submitButton(Yii::t('backend', 'Sign up for notifications <i class="fa fa-check" aria-hidden="true"></i>'), ['class' => 'btn 
                    btn-deep-purple text-white']) ?>


            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>
<!-- The core Firebase JS SDK is always required and must be listed first -->

<?php

?>
