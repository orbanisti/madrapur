<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
$this->title = $model->title;
\frontend\assets\MdbAsset::register($this);
?>
<div class="content">
    <?php echo $model->body ?>
</div>