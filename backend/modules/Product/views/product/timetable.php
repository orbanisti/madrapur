<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

\kartik\datetime\DateTimePickerAsset::register($this);

?>
<?php

?>


<?php
if (Yii::$app->session->hasFlash('error')) {
    echo '<p class="has-error flashes"><span class="help-block help-block-error">' . Yii::$app->session->getFlash('error') . '</span></p>';
} elseif (Yii::$app->session->hasFlash('success')) {
    echo '<p class="has-success flashes"><span class="help-block help-block-success">' . Yii::$app->session->getFlash('success') . '</span></p>';
}

$form = ActiveForm::begin([
    'id' => 'product-edit',
    'action' => 'update?prodId=' . $prodId,
    'options' => ['class' => 'product-edit', 'enctype' => 'multipart/form-data'],

]); ?>


<div class="tab-pane" id="timetable">
    <?php

    ?>


    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>
                <i class="glyphicon glyphicon-euro"></i> <?= Yii::t('app', 'TimeTable') ?>    <?= Html::submitButton('Termék Frissítése', ['class' => 'btn btn-primary prodUpdateBtn']) ?>
                <button type="button" class="add-item btn btn-success btn-sm pull-right"><i
                            class="glyphicon glyphicon-plus"></i> <?= Yii::t('app', 'Új') ?></button>
            </h4>
        </div>
        <div class="panel-body">
            <script>

                var prodId =<?=$prodId?>;

            </script>
            <?php

            $JSEventClick = <<<EOF
function(calEvent, jsEvent, view) {
    
    var m=new Date(calEvent.start)
    var Year=m.getUTCFullYear();
    var Month=m.getUTCMonth()+1;
    var Day=m.getUTCDate();
    if(Month<10)Month='0'+Month;
    if(Day<10)Day='0'+Day;
    dateString = Year+'-'+Month+'-'+Day;

    urlToGoTo="/Product/product/daye?date="+dateString+"&prodId="+prodId;
    //console.log(view);
    window.location.href=urlToGoTo
    //alert('Event: ' + urlToGoTo);

    //alert('Source: ' + calEvent.nonstandard['field1']);
    // change the border color just for fun
    $(this).css('border-color', 'red');
}
EOF;

            $events = array();
            //Testing
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = 1;
            $Event->title = 'Testing';
            $Event->start = date('Y-m-d\TH:i:s\Z');
            $Event->nonstandard = [
                'field1' => 'Something I want to be included in object #1',
                'field2' => 'Something I want to be included in object #2',
            ];
            $events[] = $Event;

            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = 2;
            $Event->title = 'Testing';
            $Event->start = date('Y-m-d\TH:i:s\Z', strtotime('tomorrow 6am'));
            $events[] = $Event;

            ?>

            <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
                'events' => $modelEvents,
                'clientOptions' => [
                    'locale' => 'hu',
                    'eventClick' => new \yii\web\JsExpression($JSEventClick),

                ]
            ));

            ?>


        </div>


    </div>

</div>



