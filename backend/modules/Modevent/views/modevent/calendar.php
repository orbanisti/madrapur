<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\Modevent\models\ModeventSearch $searchModel
 */


?>

<div class="row">
    <div class="col-12">
        <!-- interactive chart -->
        <div class="card card-primary card-outline">
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

                <?php
                    $events = array();
                    foreach ($allEvents as $newEvent){

                        $begin = new DateTime($newEvent->startDate);
                        $end = new DateTime($newEvent->endDate);

                        $interval = DateInterval::createFromDateString('1 day');

                        $period = new DatePeriod($begin, $interval, $end);
                        if(!isset($newEvent->place)){
                            foreach ($period as $dt) {
                                $Event = new \yii2fullcalendar\models\Event();
                                $Event->id = $newEvent->id.'###'.$dt->format('Y-m-d');
                                $Event->title = $newEvent->user;
                                $Event->start = $dt->format('Y-m-d');
                                if($newEvent->title=='subscribe'){
                                    $Event->resourceId = 'att';
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
  console.log('drop the bass'+dateString+calEvent.resourceId);
 doSave(calEvent.title,dateString,calEvent.resourceId);
  
}
EOF;

                    }else{
                        $JSEventClick=<<<EOF
function(calEvent, jsEvent, view) {alert("[no - no]");}
EOF;
                    }

                ?>
                    <script>
                        function doSave(user,date,place){

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

                    </script>
                <?= \edofre\fullcalendarscheduler\FullcalendarScheduler::widget([
                                                                                    'header'        => [
                                                                                        'left'   => 'today prev,next',
                                                                                        'center' => 'title',
                                                                                        'right'  => 'basicDay,timelineThreeDays',
                                                                                    ],

                                                                                    'clientOptions' => [
                                                                                        'now'               => date('Y-m-d',time()),
                                                                                        'editable'          => true, // enable draggable events
                                                                                        'aspectRatio'       => 1.8,
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
                                                                                        'resourceLabelText' => 'Rooms',
                                                                                        'resources'         =>
                                                                                            \yii\helpers\Url::to
                                                                                            (['modevent/resources','id'=>1]),
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

