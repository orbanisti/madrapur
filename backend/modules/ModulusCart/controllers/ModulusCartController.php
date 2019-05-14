<?php

namespace backend\modules\ModulusCart\controllers;

use Yii;
use backend\controllers\Controller;

/**
 * Controller for the `ModulusCart` module
 */
class ModulusCartController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        return $this->render('admin');
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
