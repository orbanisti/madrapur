<?php

namespace backend\modules\Modulusbuilder\controllers;

use Yii;
use backend\controllers\Controller;

/**
 * Controller for the `Modulusbuilder` module
 */
class ModulusbuilderController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        return $this->renderPartial('admin');
    }


    public function actionEmail(){

        return $this->renderPartial('email');

    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
