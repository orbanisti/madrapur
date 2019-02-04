<?php

namespace backend\modules\Products

namespace app\modules\Products\controllers;



//use yii\web\Controller;

use app\components\Controller;



class DefaultController extends Controller

{

    public function actionIndex()

    {

        return $this->render('index');

    }

}

