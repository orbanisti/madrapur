<?php





use yii\helpersbackend\l;








/* @var $this yii\web\View */


/* @var $model app\modules\Products\models\Cities */





$this->title = Yii::t('app', 'Új város');


$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Városok'), 'url' => ['admin']];


$this->params['breadcrumbs'][] = $this->title;


?>


<div class="cities-create">





    <h1><?= Html::encode($this->title) ?></h1>





    <?= $this->render('_form', [


        'model' => $model,


        'modelTranslations' => $modelTranslations


    ]) ?>





</div>


