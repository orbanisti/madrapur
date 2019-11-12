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

?>
<div class="container-fluid">

    <div class="row">
        <div class="col-gold-lg">
            <div class="card card-cascade wider reverse my-4">

                <!-- Card image -->
                <?php


                    $thumbnail=Yii::$app->fileStorage->baseUrl.$model->thumbnail_path;


                ?>
                <?php

                 /*   echo Html::img(Yii::$app->thumbnailer->get($thumbnail,200,200,10,
                                                               ManipulatorInterface::THUMBNAIL_INSET),['class'=>'card-img-top'])

                    ;*/?>
           <div class="view view-cascade overlay" style="max-height:200px;">
                    <img class="card-img-top" src="<?=$thumbnail?>? "
                         alt="Card
                    image cap">
               <?php

               ?>
                    <a href="#!">
                        <div class="mask rgba-white-slight waves-effect waves-light"></div>
                    </a>
                </div>

                <!-- Card content -->
                <div class="card-body card-body-cascade text-">

                    <!-- Title -->
                    <h1 class="card-title"><?php echo $model->title ?></h1>
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

            </div>
        </div>
    </div>
</div>
