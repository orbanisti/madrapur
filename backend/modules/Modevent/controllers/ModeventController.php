<?php

namespace backend\modules\Modevent\controllers;

use backend\modules\Modevent\models\Modevent;
use backend\modules\Modevent\models\Workshift;
use backend\modules\Reservations\models\Reservations;
use common\models\User;
use edofre\fullcalendarscheduler\models\Resource;
use Yii;
use backend\controllers\Controller;
use yii\data\ActiveDataProvider;

/**
 * Controller for the `Modevent` module
 */
class ModeventController extends ModeventCrudController {



    public function actionCalendar()
    {
        $query=Modevent::find();
        $allEvents=$query->all();


        return $this->render('calendar', [
            'allEvents'=>$allEvents
        ]);
    }

    public function actionPeeper(){

        $query=Modevent::find();
        $dayUsers=$query->andFilterWhere(['=','startDate',date('Y-m-d',time())])->andFilterWhere(['=','title',
                                                                                                  'arranged'])->all();


        return $this->render('peeper', [
            'modevents'=>$dayUsers

        ]);
    }


    public function actionMywork(){

        if($workstart=Yii::$app->request->post('work'))
        {
            $workAboutToStart=Modevent::findOne($workstart);
            $workAboutToStart->status='working';
            $workAboutToStart->save();
            return $this->redirect(Yii::$app->request->referrer);

        }

        if($workstart=Yii::$app->request->post('work-end'))
        {

//            $workAboutToStart=Modevent::findOne($workstart);
//            $workAboutToStart->status='worked';
//            $workAboutToStart->save();
            return $this->redirect('/Reservations/reservations/dayover');

        }

        if($workstart=Yii::$app->request->post('dayover'))
        {

//            $workAboutToStart=Modevent::findOne($workstart);
//            $workAboutToStart->status='worked';
//            $workAboutToStart->save();
            return $this->redirect('/Reservations/reservations/dayover');

        }


        $toprint=Modevent::find()->andFilterWhere(['=','user',Yii::$app->user->getIdentity()->username])->andWhere('`title`=\'arranged\'')->orderBy('startDate');

        if($workdate=Yii::$app->request->get('date')){
            $toprint->andFilterWhere(['=','startDate',$workdate]);

        }
        $toprint=$toprint->all();

        return $this->render('mywork', [
            'toprint'=>isset($toprint) ? $toprint : null,

        ]);
    }
    public function actionWorkshift()
    {

        $model=new Workshift();
        $dataProvider= new ActiveDataProvider([
                                                  'query' => Workshift::find()->indexBy('id'),
                                                  'pagination' => [
                                                      'pageSize' => 15,
                                                  ],
                                              ]);

        if(Yii::$app->request->get('delete')==1){
            $deletemodel=Workshift::findOne(Yii::$app->request->get('id'));
            if($deletemodel){
                $deletemodel->delete();
            }

        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            sessionSetFlashAlert(
                'info',
                "Successful Workshift creation: <span class='bg-dark'>".$model->place."</span>"
            );
            return $this->render('workshift', [

                'dataProvider'=>$dataProvider,
                'searchModel'=> $model
//            'allEvents'=>$allEvents
            ]);
        }

        return $this->render('workshift', [
            'dataProvider'=>$dataProvider,
            'searchModel'=> $model
        ]);

    }

    public function actionSave(){

            $model=new Modevent();
            $model->user=Yii::$app->request->post('user');
            $model->startDate=Yii::$app->request->post('date');
            $model->place=Yii::$app->request->post('place');
            $model->title=Yii::$app->request->post('title');
            $model->status=Yii::$app->request->post('status');
            $model->save();
            return 1;





    }

    public function actionResources($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $workshifts=Workshift::find()->all();
        $allResources=[];
        foreach($workshifts as $workshift){
            $duration=date('H:i',strtotime($workshift->startTime))."-".date('H:i',strtotime($workshift->endTime));

            $newResource = new Resource(['id'=>$workshift->id,'title' => $workshift->place,'eventBackgroundColor' => '#17a2b8','eventClassName'=>$duration,'eventBorderColor' => $workshift->role]);
            $allResources[]=$newResource;
        }



        $allResources[]=  new Resource(['id' => 'attAM', 'title' =>
                    'Attendees','eventClassName'=>'Attendees','eventBorderColor' => 'AM']);
        $allResources[]=  new Resource(['id' => 'attPM', 'title' =>
                    'Attendees','eventClassName'=>'Attendees','eventBorderColor' => 'PM']);
        $allResources[]=  new Resource(['id' => 'attEB', 'title' =>
                    'Everybody','eventClassName'=>'Every','eventBorderColor' => 'Body']);

        return $allResources;

//        return [
//
//
//                new Resource(['id' => 'coordinator2', 'title' => 'Koordinátor2']),
//                new Resource(['id' => 'rakpart', 'title' => 'Rakpart']),
//                new Resource(['id' => 'vaci', 'title' => 'Váci', 'eventColor' => 'green']),
//                new Resource(['id' => 'utcasarok', 'title' => 'Utcasarok', 'eventColor' => 'orange']),
//                new Resource([
//                    'id'       => 'Dock', 'title' => 'Dock',
//                    'children' => [
//                        new Resource(['id' => 'dockde', 'title' => 'Dock délelőtt']),
//                                     new Resource(['id' => 'dockdu', 'title' => 'Dock délelután']),
//                    ],
//                ]),
//                new Resource(['id' => 'att', 'title' =>
//                    'Attendees'])
//
//
//        ];


    }
    public function actionSubscribe()
    {
        $model=new Modevent();

        $dataProvider=$model->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            sessionSetFlashAlert('success', '<i class="fas fa-check-circle fa-fw "></i>Successful subscription!');

            return $this->redirect(['subscribe', 'id' => $model->id]);
        }
        return $this->render('subscribe', ['model' => $model,'dataProvider'=>$dataProvider
        ]);
    }
}
