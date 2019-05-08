<?php

namespace backend\modules\Payment\controllers;

use Yii;
use backend\controllers\Controller;

/**
 * Controller for the `Payment` module
 */
class PaymentController extends Controller {
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
