<?php

namespace backend\modules\Products\controllers;



use yii\web\Controller;

//use backend\components\Controller;



class DefaultController extends Controller

{

    public function actionIndex()

    {

        return $this->render('index');

    }

}

