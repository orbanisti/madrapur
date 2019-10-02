<?php

namespace backend\modules\Modevent\controllers;

use backend\modules\Modevent\models\Modevent;
use Yii;
use backend\controllers\Controller;

/**
 * Controller for the `Modevent` module
 */
class ModeventController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        $model= new Modevent();
        $model->title='asd';
        return $this->render('admin',['model'=>$model]);
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
