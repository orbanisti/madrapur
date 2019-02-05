<?phpbackend\
use yii\helpers\Html;
use app\modules\Users\Module as Usermodule;
?>
 
<div class="panel panel-body" style="text-align: center;">
    <div class="page-header">
        <h1><?= Yii::t('app','Facebook Bejelentkezés') ?></h1>
    </div>
    <?= $out ?>    
    <hr>
    <?= Html::a(Yii::t('app','Vissza'), Usermodule::$loginUrl, ['class'=>'btn btn-success']) ?>
</div>