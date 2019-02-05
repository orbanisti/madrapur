<?php

namespace app\modules\Staticpages\controllers;

//use yii\web\Controller;
use app\components\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
