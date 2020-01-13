<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\rbac\models\RbacAuthAssignment */

?>


<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-pen"></i>
                    <?=Yii::t('app', 'Create {modelClass}', [
                        'modelClass' => 'Rbac Auth Assignment',
                    ])?>
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">
                <div class="rbac-auth-assignment-create">

                    <?php

                        echo $this->render('_form', [
                            'model' => $model,
                        ]) ?>

                </div>

            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>
