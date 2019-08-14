<?php
/**
 * @var $this yii\web\View
 * @var $content string
 */
?>
<?php $this->beginContent('@backend/views/layouts/common.php'); ?>
<div class="box">
	<div class="box-body">
<!--        <script src="https://unpkg.com/react@16/umd/react.development.js"></script>-->
<!--        <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>-->
<!--        <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>-->
        <?php echo $content ?>
    </div>
</div>
<?php $this->endContent(); ?>
