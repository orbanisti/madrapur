<?php



use yii\helpers\Html;

use yii\widgetsbackend\ailView;



/* @var $this yii\web\View */

/* @var $model app\modules\Users\models\Userpartners */



$this->title = $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Userpartners'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="userpartners-view">



    <h1><?= Html::encode($this->title) ?></h1>



    <p>

        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [

            'class' => 'btn btn-danger',

            'data' => [

                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),

                'method' => 'post',

            ],

        ]) ?>

    </p>



    <?= DetailView::widget([

        'model' => $model,

        'attributes' => [

            'id',

            'user_id',

            'partner_id',

        ],

    ]) ?>



</div>

