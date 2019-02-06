<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use kartik\helpers\Html;
use backend\components\extra;

$this->title = Yii::t('app', 'QR kódok');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'sku',
            'claimed_on',
            'hash',
            'views',
            'until'
        ];

        echo \yii\grid\GridView::widget([
            'pager' => [
                'firstPageLabel' => Yii::t('app','Első oldal'),
                'lastPageLabel'  => Yii::t('app','Utolsó oldal'),
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
        ]);
    ?>

</div>