<?phpbackend\



use yii\helpers\Html;

use yii\widgets\DetailView;



/* @var $this yii\web\View */

/* @var $model app\modules\Users\models\Users */



$this->title = $model->username;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="users-view">

        <p>

            <?= Html::a(Yii::t('app', 'Jelszó megváltoztatása'), ['changepassword'], ['class' => 'btn btn-primary']) ?>
            
            <?= Html::a(Yii::t('app', 'Email cím megváltoztatása'), ['changeemail'], ['class' => 'btn btn-primary']) ?>

            <?= Html::a(Yii::t('app', 'Profilom szerkesztése'), ['edit'], ['class' => 'btn btn-primary']) ?>

            <?php /*Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [

                'class' => 'btn btn-danger',

                'data' => [

                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),

                    'method' => 'post',

                ],

            ])*/ ?>

        </p>



        <?= DetailView::widget([

            'model' => $model,

            'attributes' => [

                'email:email',

                'username',

                'regdate',

            ],

        ]) ?>

        

        <?= Html::img($model->profile->thumb) ?>

</div>

