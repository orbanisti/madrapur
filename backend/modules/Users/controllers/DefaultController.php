<?php

backend\

namespbackend\app\modules\Users\controllers;



//use app\components\Controller;

use yii\web\Controller;



class DefaultController extends Controller

{

    public function actionIndex()

    {

        return $this->render('index');

    }

}

