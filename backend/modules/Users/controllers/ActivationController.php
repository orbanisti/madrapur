<?php

backend\

namespace app\modules\Users\controllers;
backend\
backend\
backend\
use backend\

use app\modules\Users\Module as Usermodule;

use app\modules\Users\models\Users;

use app\modules\Users\models\forms\SendmailForm;

use app\components\Controller;

//use yii\web\Controller;



class ActivationController extends Controller

{

    

    public $defaultAction = 'activation';

    

    public function actionActivation()

    {

        

        /*if (!Yii::$app->user->isGuest) {

            return $this->redirect(Usermodule::$profileUrl);

        }*/

        

        $email=Yii::$app->request->get('email');

        $activkey=Yii::$app->request->get('activkey');

        

        $title =  Yii::t('app', 'Profil aktiválása');

        

        $user=Users::findOne(['email'=>$email,'hashcode'=>$activkey,'status'=>Usermodule::STATUS_NOACTIVE]);

        if(!empty($user))

        {

            $user->hashcode=UserModule::encrypting(microtime());

            $user->status=UserModule::STATUS_ACTIVE;

            $user->save(false);

            $message=Yii::t('app', 'Regisztrációja aktív, most már be tud jelentkezni.');

        } else {

            $message=Yii::t('app', 'Helytelen aktiváló url.');

        }

        

        return $this->render('/users/message', [

            'message' => $message,

            'title' => $title,

        ]);

    }

    

    public function actionSendmail()

    {

        if (!\Yii::$app->user->isGuest) {

            return $this->redirect(Usermodule::$profileUrl);

        }



        $model = new SendmailForm();

        if ($model->load(Yii::$app->request->post()) && $model->sendmail()) {

            return $this->render('/users/message', [

                'message' => 'Aktiváló email elküldve. Az emailben található linkre kattintva aktiválhatja a profilját.',

                'title' => 'Aktiváló email',

            ]);

        }

        

        return $this->render('sendmail', [

            'model' => $model,

        ]);

    }



}

