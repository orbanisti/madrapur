<?phpbackend\backend\

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\Users\Module as Usermodule;

$this->title = Yii::t('app', 'Felhasználók');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?= Html::a(Yii::t('app', 'Create Users'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?= GridView::widget([
        'pager' => [
            'firstPageLabel' => Yii::t('app','Első oldal'),
            'lastPageLabel'  => Yii::t('app','Utolsó oldal'),
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'email:email',
            'username',
            ['attribute' => 'dividend',
                'value' => function ($model) {
                        return $model->dividend.'%';
                },
            ],
            ['attribute' => 'dividendprice',
                'format'=>'raw',
                'value' => function ($model) {
                        return app\models\Shopcurrency::priceFormat($model->dividendprice);
                },
            ],
            'regdate',
            ['attribute' => 'status',
                'value' => function ($model) {
                        return Usermodule::status($model->status);
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', Usermodule::status(),['class'=>'form-control','prompt' => '']),
            ],
            ['attribute' => 'type',
                'value' => function ($model) {
                        return Usermodule::type($model->type);
                },
                'filter' => Html::activeDropDownList($searchModel, 'type', Usermodule::type(),['class'=>'form-control','prompt' => '']),
            ],
            ['attribute' => 'payment_in_advance',
                'value' => function ($model) {
                        return Usermodule::paymentad($model->payment_in_advance);
                },
                'filter' => Html::activeDropDownList($searchModel, 'payment_in_advance', Usermodule::paymentad(),['class'=>'form-control','prompt' => '']),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}'
            ],
        ],
    ]); ?>

</div>