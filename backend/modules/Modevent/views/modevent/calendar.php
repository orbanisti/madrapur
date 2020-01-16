<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;


    $monday=date('Y-m-d',strtotime('last monday'));
    if(date('Y-m-d',strtotime('today'))==date('Y-m-d',strtotime('monday'))){
        $monday=date('Y-m-d',strtotime('monday'));
    }

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\Modevent\models\ModeventSearch $searchModel
 */


?>
<script>
    function printPreview() {
        var headerElements = document.getElementsByClassName('fc-header');//.style.display = 'none';
        for(var i = 0, length = headerElements.length; i < length; i++) {
            headerElements[i].style.display = 'none';
        }
        var toPrint = document.getElementById('calendar').cloneNode(true);

        for(var i = 0, length = headerElements.length; i < length; i++) {
            headerElements[i].style.display = '';
        }

        var linkElements = document.getElementsByTagName('link');
        var link = '';
        for(var i = 0, length = linkElements.length; i < length; i++) {
            link = link + linkElements[i].outerHTML;
        }

        var styleElements = document.getElementsByTagName('style');
        var styles = '';
        for(var i = 0, length = styleElements.length; i < length; i++) {
            styles = styles + styleElements[i].innerHTML;
        }

        var popupWin = window.open('', '_blank');
        popupWin.document.open();
        popupWin.document.write('<html><title>Schedule Preview</title>'+link
            +'<style>'+styles+'</style></head><body">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
        setTimeout(function(){popupWin.print() }, 1000);

    }
</script>
<style>
    .fc-license-message{
        display: none !important;
    }

    @media print {

        div.fc-license-message{
            display: none !important;
        }
        .fc-content {
            border-top: 1px solid lightgray !important;
        }


        th,thead{height:150px!important;}

        body, html, #wrapper {
            width: 100%;
        }
        div {
            overflow: visible !important;
        }
        [data-resource-id="attAM"],[data-resource-id="attPM"],[data-resource-id="attEB"] {
               display:none;
           }
    }


    .fc-widget-header:first-of-type, .fc-widget-content:first-of-type{border-bottom: 0px !important;}
</style>
<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-alt fa-fw "></i>
                    Workflow Calendar

                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-info"
                      ><i
                            class="fas fa-print" onClick="printPreview()"></i></button>
                <?php
                    $events = array();
                    foreach ($allEvents as $newEvent){

                        $begin = new DateTime($newEvent->startDate);

                        $endTimifyed=date('Y-m-d',strtotime($newEvent->endDate.' +1 day'));

                        $end = new DateTime($endTimifyed);


                        $interval = DateInterval::createFromDateString('1 day');

                        $period = new DatePeriod($begin, $interval, $end);
                        if(!isset($newEvent->place)){
                            foreach ($period as $dt) {
                                $Event = new \yii2fullcalendar\models\Event();
                                $Event->id = $newEvent->id.'###'.$dt->format('Y-m-d');
                                $Event->title = $newEvent->user;
                                $Event->start = $dt->format('Y-m-d');
                                if($newEvent->title=='subscribe' &&$newEvent->status=='PM'){
                                    $Event->resourceId = 'attPM';
                                }

                                if($newEvent->title=='subscribe' &&$newEvent->status=='AM'){
                                    $Event->resourceId = 'attAM';
                                }

                                if($newEvent->title=='subscribe' && $newEvent->status=='All day'){
                                    $Event->resourceId = 'attAM';
                                    $Event->id.=$Event->resourceId;
                                    $events[] = $Event;
                                    $Event = new \yii2fullcalendar\models\Event();
                                    $Event->id = $newEvent->id.'###'.$dt->format('Y-m-d');
                                    $Event->title = $newEvent->user;
                                    $Event->start = $dt->format('Y-m-d');
                                    $Event->resourceId = 'attPM';
                                    $Event->id.=$Event->resourceId;

                                }



                                $Event->nonstandard = [
                                    'field1' => 'Something I want to be included in object #1',

                                ];
                                $events[] = $Event;

                            }

                        }
                        else{
                            $Event = new \yii2fullcalendar\models\Event();
                            $Event->id = $newEvent->id.'###'.$newEvent->place;
                            $Event->title = $newEvent->user;
                            if($newEvent->status=='worked'){
                                $Event->title = $newEvent->user.' ✓';
                                $Event->color='limegreen';
                            }
                            $Event->start = $newEvent->startDate;
                            $Event->resourceId=$newEvent->place;

                            $events[] = $Event;
                        }

                    }
                    $streetSellers=\common\models\User::getStreetSellers();


                    $begin = new DateTime(date('Y-m-d',strtotime($monday)));

                    $end = new DateTime(date('Y-m-d',strtotime('+7 days')));

                    $interval = DateInterval::createFromDateString('1 day');

                    $period = new DatePeriod($begin, $interval, $end);

                    foreach ($period as $dt){
                        foreach ($streetSellers as $index=>$seller){
                            $Event = new \yii2fullcalendar\models\Event();
                            $Event->id = rand().'###'.$dt->format('Y-m-d');
                            $Event->title =$seller->getPublicIdentity();
                            $Event->start = $dt->format('Y-m-d');
                            $Event->resourceId='attEB';
                            $Event->nonstandard = [
                                'username' => $seller->username,

                            ];
                            $events[]=$Event;
                        }
                    }









                    //Testing

                    if(Yii::$app->user->can('streetAdmin') || Yii::$app->user->can('administrator')){

                        $JSEventClick = <<<EOF
function(calEvent, jsEvent, view) {
  
    var m=new Date(calEvent.start);
    var Year=m.getUTCFullYear();
    var Month=m.getUTCMonth()+1;
    var Day=m.getUTCDate();
    if(Month<10)Month='0'+Month;
    if(Day<10)Day='0'+Day;
    dateString = Year+'-'+Month+'-'+Day;

 doSave(calEvent.nonstandard["username"],dateString,calEvent.resourceId,calEvent.id);
  
}
EOF;

                    }else{
                        $JSEventClick=<<<EOF
function(calEvent, jsEvent, view) {alert("[no - no]");}
EOF;
                    }

                ?>
                    <script>
                        function doSave(user,date,place,id){
                            if(place!='attAM' && place!='attPM' && place!='attEB'){
                                $.ajax({
                                    url: '<?php echo Yii::$app->request->baseUrl. 'save' ?>',
                                    type: 'post',
                                    data: {
                                        user: user,
                                        date:date,
                                        place:place,
                                        title:'arranged',
                                        status:'notyet',
                                        _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
                                    },
                                    success: function (data) {
                                        console.log(data.search);
                                    }
                                });

                            }
                            else{
                                var eventId=id.split("###")[0];
                                console.log(eventId);
                                $.ajax({
                                    url: '<?php echo Yii::$app->request->baseUrl. 'delete?id=' ?>'+eventId,
                                    type: 'post',
                                    id:eventId,
                                    data: {
                                        id: eventId,
                                        _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
                                    },
                                    success: function (data) {
                                        console.log(data.search);
                                    }
                                });




                            }



                        }

                    </script>
                <?php









                ?>
                <?= \edofre\fullcalendarscheduler\FullcalendarScheduler::widget([
                                                                                    'header'        => [
                                                                                        'left'   => 'today prev,next',
                                                                                        'center' => 'title',
                                                                                        'right'  => 'basicDay,timelineThreeDays',
                                                                                    ],

                                                                                    'clientOptions' => [
                                                                                        'now'               => $monday,
                                                                                        'editable'          => true, // enable draggable events
                                                                                        'aspectRatio'       => 1,
                                                                                         'plugins'=>[   'resourceDayGridPlugin' ],
                                                                                        'scrollTime'        => '00:00', // undo default 6am scrollTime
                                                                                        'defaultView'       => 'timelineThreeDays',
                                                                                        'locale'=>'hu',
                                                                                        'views'             => [
                                                                                            'timelineThreeDays' => [
                                                                                                'type'     => 'timeline',
                                                                                                'duration' => [
                                                                                                    'days' => 7,
                                                                                                ],
                                                                                                'slotDuration' => [
                                                                                                    'days' => 1,
                                                                                                ],

                                                                                            ],
                                                                                            'agendaTwoDay' => [
                                                                                                'type'            => 'agenda',
                                                                                                'duration'        =>
                                                                                                    ['days' => 5],
                                                                                                // views that are more than a day will NOT do this behavior by default
                                                                                                // so, we need to explicitly enable it
                                                                                                //'groupByResource' =>true,
                                                                                                //// uncomment this line to group by day FIRST with resources underneath
                                                                                                'groupByDateAndResource'=>true,
                                                                                            ],
                                                                                            'timelineFourDays' => [
                                                                                                'type'     => 'agendaWeek',
                                                                                                'duration' => [
                                                                                                    'days' => 7,
                                                                                                ],

                                                                                            ],
                                                                                        ],
                                                                                        'resourceLabelText' => 'Workshifts',
                                                                                        'resources'         =>$resources,
                                                                                        'resourceRender'    => new \yii\web\JsExpression("
			function(resource, leftCells, rightCells) {
				if (resource.id != 'att') {
				   
					leftCells.css('display', 'block');
					timeBadge=document.createElement(\"span\"); 
					roleBadge=document.createElement(\"span\"); 
					timeBadge.className='badge pull-right badge-info';
					roleBadge.className='badge pull-right badge-warning';
					
					var timeText = document.createTextNode(resource.eventClassName[0]);
					var roleText = document.createTextNode(resource.eventBorderColor);
					console.log(resource.eventBorderColor);
					timeBadge.append(timeText);
					roleBadge.append(roleText);
					textCell=leftCells.find('.fc-cell-content');
					textCell.append(timeBadge);
					textCell.append(roleBadge);
					
				}
			}
		"),
                                                                                        'events'            =>
                                                                                            $events,
                                                                                        'eventDrop'=> new
                                                                                   \yii\web\JsExpression
                                                                                   ($JSEventClick),
                                                                                    ],
                                                                                ]);
                ?>

            </div>
            <!-- /.card-body-->
        </div>
        <!-- /.card -->

    </div>

    <!-- /.col -->
</div>

