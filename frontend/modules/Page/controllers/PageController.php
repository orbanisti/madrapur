<?php

namespace frontend\modules\Page\controllers;

use Yii;
use backend\controllers\Controller;

/**
 * Controller for the `Page` module
 */
class PageController extends Controller {
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
