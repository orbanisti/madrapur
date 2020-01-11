<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;

?>
<hr />
<div class="article-item row">
	<div class="col-xs-12">
		<h2 class="article-title">
            <?php echo Html::a($model->title, ['view', 'slug'=>$model->slug]) ?>
        </h2>
		<div class="article-meta">
			<span class="article-date">
                <?php echo $model->category; ?>
            </span>, <span class="article-category">

            </span>
		</div>
		<div class="article-content">
            <?php if ($model->thumbnail): ?>
                <?php

echo Html::img(Yii::$app->glide->createSignedUrl([
                    'glide/index',
                    'path' => Yii::$app->fileStorage->baseUrl.$model->thumbnail,
                    'w' => 100
                ], true), [
                    'class' => 'article-thumb img-rounded pull-left'
                ])?>
            <?php endif; ?>
            <div class="article-text">
                <?php echo \yii\helpers\StringHelper::truncate($model->short_description, 150, '...', null, true) ?>
            </div>
		</div>
	</div>
</div>
