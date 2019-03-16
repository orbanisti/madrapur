<?php

namespace backend\modules\Product\controllers;

use Yii;
use backend\controllers\Controller;
use backend\modules\Product\models\ProductUpdate;

/**
 * Controller for the `Product` module
 */
class ProductController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        return $this->render('admin');
    }
    public function actionCreate() {
        $model= new ProductUpdate();
        return $this->render('create',['model'=>$model]);
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
