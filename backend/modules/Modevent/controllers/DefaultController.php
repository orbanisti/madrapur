<?php

namespace backend\modules\Modevent\controllers;

use yii\web\Controller;

/**
 * Default controller for the `modevent` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
