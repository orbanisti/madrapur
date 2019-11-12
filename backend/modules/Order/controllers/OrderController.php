<?php

namespace backend\modules\Order\controllers;

use backend\controllers\Controller;

/**
 * Controller for the `Order` module
 */
class OrderController extends Controller {
    /**
     * Renders the admin view for the module
     *
     * @return string
     */
    public function actionAdmin() {
        return $this->render('admin');
    }

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
