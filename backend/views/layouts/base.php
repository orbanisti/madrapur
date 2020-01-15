<?php
use backend\assets\BackendAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $content string */

$bundle = BackendAsset::register($this);

$this->params['body-class'] = $this->params['body-class'] ?? null;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
<meta charset="<?php echo Yii::$app->charset ?>">
<meta
	content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
	name='viewport'>

    <?php echo Html::csrfMetaTags() ?>
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        @media only screen and (max-width:500px){
            .content-header{
                padding: 3px 0.5rem;
            }

            .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto{
                padding-right: 1.5px;
                padding-left: 1.5px;
            }

            .container-fluid{
                padding-right: 1.5px;
                padding-left: 1.5px;
            }

            .btn.btn-flat{
                width: 45%;
            }

            .btn-info{
                width: 100%;
            }

            .kartik-sheet-style{
                display:flex;
            }

            .kv-grid-demo{
                display:flex;
            }

            .table th, .table td{
                font-size: 15px!important;
                border: none!important;
                margin: 4px 0px!important;
            }

            .panel-heading{
                text-align:center;
            }

            .panel-body > .panel-body{
                padding: 5px;
                border-bottom: 10px solid white;
            }

            .datepicker table{
                width:100%!important;
            }

            .border-secondary{
                box-shadow: 0px 0px 5px 2px #17a2b8;
            }
        }
    </style>

</head>
<?php

echo Html::beginTag('body',
        [
            'class' => implode(' ',
                    [
                        ArrayHelper::getValue($this->params, 'body-class'),
                        Yii::$app->keyStorage->get('backend.theme-skin', 'skin-blue'),
                        Yii::$app->keyStorage->get('backend.layout-fixed') ? 'layout-fixed' : null,
                        Yii::$app->keyStorage->get('backend.layout-boxed') ? 'layout-boxed' : null,
                        Yii::$app->keyStorage->get('backend.layout-collapsed-sidebar') ? 'sidebar-collapse' : 'sidebar-collapse',
                        'sidebar-mini'
                    ])
        ])?>
    <?php $this->beginBody() ?>
        <?php echo $content ?>
    <?php $this->endBody() ?>
<?php echo Html::endTag('body') ?>
</html>
<?php $this->endPage() ?>
