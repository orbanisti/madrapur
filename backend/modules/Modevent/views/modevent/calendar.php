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
                    $Event->start = date('Y-m-d\TH:i:s\Z',strtotime('tomorrow 6am'));
                    $events[] = $Event;

                ?>

                <?= \edofre\fullcalendarscheduler\FullcalendarScheduler::widget([
                                                                                    'header'        => [
                                                                                        'left'   => 'today prev,next',
                                                                                        'center' => 'title',
                                                                                        'right'  => 'basicDay,timelineThreeDays',
                                                                                    ],

                                                                                    'clientOptions' => [
                                                                                        'now'               => '2016-05-07',
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
                                                                                        'resources'         => [
                                                                                            ['id' => 'a', 'title' => 'Rakpart'],
                                                                                            ['id' => 'b', 'title' => 'Váci', 'eventColor' => 'green'],
                                                                                            ['id' => 'c', 'title' => 'Utcasarok', 'eventColor' => 'orange'],
                                                                                            [
                                                                                                'id'       => 'd', 'title' => 'Dock',
                                                                                                'children' => [
                                                                                                    ['id' => 'd1', 'title' => 'Dock délelőtt'],
                                                                                                    ['id' => 'd2', 'title' => 'Dock délelután'],
                                                                                                ],
                                                                                            ],
                                                                                            ['id' => 'e', 'title' => 'Auditorium E'],

                                                                                        ],
                                                                                        'events'            => [
                                                                                            ['id' => '1', 'resourceId' => 'b', 'start' => '2016-05-07T02:00:00', 'end' => '2016-05-07T07:00:00', 'title' => 'event 1'],
                                                                                            ['id' => '2', 'resourceId' => 'c', 'start' => '2016-05-07T05:00:00', 'end' => '2016-05-07T22:00:00', 'title' => 'event 2'],
                                                                                            ['id' => '3', 'resourceId' => 'd', 'start' => '2016-05-06', 'end' => '2016-05-08', 'title' => 'event 3'],
                                                                                            ['id' => '4', 'resourceId' => 'e', 'start' => '2016-05-07T03:00:00', 'end' => '2016-05-07T08:00:00', 'title' => 'event 4'],
                                                                                            ['id' => '5', 'resourceId' => 'f', 'start' => '2016-05-07T00:30:00', 'end' => '2016-05-07T02:30:00', 'title' => 'event 5'],
                                                                                        ],
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