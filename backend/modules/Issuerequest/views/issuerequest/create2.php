<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\Issuerequest\models\Issuerequest $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Issuerequest',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Issuerequests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation fa-fw "></i>
                    Report an issue

                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">
                <div class="issuerequest-create">
                    <div class="page-header">

                    </div>
                    <?= $this->render('_form', [
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
