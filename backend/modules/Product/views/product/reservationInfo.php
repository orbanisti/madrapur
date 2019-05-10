<?php
/**
 * Created by PhpStorm.
 * User: ROG
 * Date: 2019. 02. 05.
 * Time: 20:38
 */

use kartik\helpers\Html;
use backend\components\extra;
use yii\widgets\ActiveForm;
use kartik\grid\EditableColumn;
use backend\models\Product\Product;




?>

<!--suppress ALL -->
<div class="reservations-info-index">
<style>
    td{
        border:1px solid black;
        padding:3px;
    }
</style>
<div class="panel">
    <div class="panel-body">
        <table>
            <?php foreach($model as $i=>$attribute){
                if(!json_decode($attribute)){

                    echo '<tr>'.'<td>'.$i.'</td>'.'<td>'.$attribute.'</td>'.'</tr>';

                }
                else{
                    $subStuff=json_decode($attribute);
                    echo '<tr>'.'<td>'.$i.'</td>'.'<td>'.$attribute.'</td>'.'</tr>';
                }

            } ?>
        </table>

    </div>
</div>