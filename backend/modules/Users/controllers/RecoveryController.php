<?php

backend\

namespace app\modules\Users\controllers;
backend\
backend\
backend\
use backend\
backend\
use app\modules\Users\Module as Usermodule;

use app\modules\Users\models\Users;

use app\modules\Users\models\forms\RecoverymailForm;

use app\modules\Users\models\forms\RecoverypasswordForm;

use app\components\Controller;

//use yii\web\Controller;



class RecoveryController extends Controller

{

    

    public $defaultAction = 'recovery';

    

    

    public function actionRecovery()

    {

        if (!\Yii::$app->user->isGuest) {

            return $this->redirect(Usermodule::$profileUrl);

        }



        $model = new RecoverymailForm();

        if ($model->load(Yii::$app->request->post()) && $model->sendmail()) {

            return $this->render('/users/message', [

                'message' => 'A jelszó megváltoztatásához szükséges email elküldve. Az emailben található linkre kattintva változtathatod meg a jelszavad.',

                'title' => 'Jelszó helyreállítás',

            ]);

        }

        

        return $this->render('sendmail', [

            'model' => $model,

        ]);

    }

    

    public function actionRecoverypassword()

    {

        $email=Yii::$app->request->get('email');

        $activkey=Yii::$app->request->get('activkey');

        

        $user=Users::findOne(['email'=>$email,'hashcode'=>$activkey]);

        

        if(!empty($user))

        {

            $model = new RecoverypasswordForm();

            $model->userid = $user->id;



            if ($model->load(Yii::$app->request->post()) && $model->recoverypassword()) {

                $message=Yii::t('app','A jelszót sikeresen megváltoztattad.');

                return $this->render('/users/message', [

                    'message' => $message,

                    'title' => 'Jelszó helyreállítás',

                ]);

            }



            return $this->render('recoverypassword', [

                'model' => $model,

            ]);

            

        } else {

            $message=Yii::t('app', 'Helytelen helyreállító url.');

        }

        

        return $this->render('/users/message', [

            'message' => $message,

            'title' => 'Jelszó helyreállítás',

        ]);

        

    }



}

