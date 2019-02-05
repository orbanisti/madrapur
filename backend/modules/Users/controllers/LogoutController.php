<?php

backend\

namespace app\modules\Users\controllers;


backend\
use Yii;

use yii\filters\AccessControl;

use yii\filters\VerbFilter;

use app\components\Controller;

//use yii\web\Controller;



class LogoutController extends Controller

{

    

    public $defaultAction = 'logout';

    

    public function behaviors()

    {

        return [

            'access' => [

                'class' => AccessControl::className(),

                'only' => ['logout'],

                'rules' => [

                    [

                        'actions' => ['logout'],

                        'allow' => true,

                        'roles' => ['@'],

                    ],

                ],

            ],

            'verbs' => [

                'class' => VerbFilter::className(),

                'actions' => [

                    'logout' => ['post'],

                ],

            ],

        ];

    }

    

    public function actionLogout()

    {

        Yii::$app->user->logout();



        return $this->goHome();

    }



}

