<?php
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')?>

<div class="wrap">
    <?php echo $content ?>
</div>

<?php $this->endContent() ?>