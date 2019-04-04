<?php

namespace api\modules\v1\controllers;

use Yii;
use backend\controllers\Controller;
use yii\rest\ActiveController;
use yii\rest\IndexAction;
use yii\rest\OptionsAction;
use yii\rest\Serializer;
use yii\rest\ViewAction;
use yii\web\HttpException;
/**
 * Controller for the `Worker` module
 */
class WorkerController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actions()
    {
        return array(
            'index' => array(
                'class' => \nizsheanez\jsonRpc\Action::class,
            ),
            'prowide' => array(
                'class' => \nizsheanez\jsonRpc\Action::class,
            ),
        );
    }

    public function behaviors() {
        $behaviors = parent::behaviors();


        return $behaviors;
    }

    public function yell($message) {
        return $message;
    }
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
