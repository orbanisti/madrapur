<?php



use yii\helpers\Html;

backend\



/* @var $this yii\web\View */

/* @var $model app\modules\Users\models\Userpartners */



$this->title = Yii::t('app', 'Új partner');

?>

<div class="userpartners-create">



    <h1><?= Html::encode($this->title) ?></h1>



    <?= $this->render('_form', [

        'model' => $model,

    ]) ?>



</div>

