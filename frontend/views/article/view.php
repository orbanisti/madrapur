<?php
/* @var $this yii\web\View */

    use Imagine\Image\ManipulatorInterface;
    use yii\bootstrap4\Html;

    /* @var $model common\models\Article */
$this->title = $model->title;
//$this->params['breadcrumbs'][] = [
//    'label' => Yii::t('frontend', 'Articles'),
//    'url' => [
//        'index'
//    ]
//];
//$this->params['breadcrumbs'][] = $this->title;

?>

<?php

    $this->registerJs(
            'objectFitImages();

/* init Jarallax */
jarallax(document.querySelectorAll(\'.jarallax\'));',\yii\web\View::POS_READY

    );
\frontend\assets\MdbAsset::register($this);
\common\assets\FontAwesome::register($this);
?>
<div class="container">


    <div class="row">
        <div class="col-12">
            <!-- interactive chart -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h1 class="card-title h1-responsive"><span><?php echo $model->title ?></span></h1>



                </div>
                <div class="card-body">

                    <!-- Card image -->
                    <?php


                        $thumbnail=Yii::$app->fileStorage->baseUrl.$model->thumbnail_path;


                    ?>


                    <!-- Card content -->
                    <style>
                        img{
                            max-width:100%;
                        }
                    </style>

                    <!-- Title -->
                    <!-- Subtitle -->
                    <div class="content">
                        <article class="article-item">



                            <?php echo $model->body ?>

                            <?php if (!empty($model->articleAttachments)): ?>
                                <h3><?php echo Yii::t('frontend', 'Attachments') ?></h3>
                                <ul id="article-attachments">
                                    <?php foreach ($model->articleAttachments as $attachment): ?>
                                        <li>
                                            <?php

                                                echo \yii\helpers\Html::a($attachment->name, [
                                                    'attachment-download',
                                                    'id' => $attachment->id
                                                ])?>
                                            (<?php echo Yii::$app->formatter->asSize($attachment->size) ?>)
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                        </article>
                    </div>


                </div>
                <!-- /.card-body-->
            </div>
            <!-- /.card -->

        </div>

        <!-- /.col -->
    </div>
</div>
