<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use backend\components\extra;
use backend\models\Product\Product;




?>

<div class="tickets-view-ticket">
    <style>
        td{
            border:1px solid black;
            padding:3px;
        }
    </style>
    <?php
    echo \yii\helpers\Html::a( 'Back', Yii::$app->request->referrer);
    ?>
    <div class="panel">
        <div class="panel-body">
            <table>
                <?php foreach($model as $i=>$attribute){
                    echo '<tr>'.'<td>'.$i.'</td>'.'<td>'.$attribute.'</td>'.'</tr>';
                } ?>
            </table>

        </div>
    </div>
</div>
