<?php

namespace backend\modules\Dashboard\controllers;

use Yii;
use backend\controllers\Controller;

/**
 * Controller for the `Dashboard` module
 */
class DashboardController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        $nextTicketId = "";
        $viewName = 'admin';

        if (Yii::$app->user->can("hotline")) {
            $viewName = 'hotlineAdmin';
        }

        if (Yii::$app->user->can("streetSeller")) {
            $viewName = 'sellerAdmin';
        }

        return $this->render(
            $viewName, [
                'nextTicketId' => $nextTicketId
            ]
        );
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
