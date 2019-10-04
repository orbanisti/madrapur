<?php

namespace backend\modules\Modevent\controllers;

use backend\modules\Modevent\models\Modevent;
use Yii;
use backend\controllers\Controller;

/**
 * Controller for the `Modevent` module
 */
class ModeventController extends ModeventCrudController {

    public function actionCalendar()
    {

        return $this->render('calendar', [
        ]);
    }
    public function actionSubscribe()
    {

        return $this->render('subscribe', ['model' => new Modevent()
        ]);
    }
}
