<?php

namespace backend\modules\Product\controllers;

use backend\modules\Product\models\ProductAddOn;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `product` module
 */
class AddOnsController extends Controller {
    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionAdmin() {
        $searchModel = new ProductAddOn();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render(
            'admin',
            [
                "dataProvider" => $dataProvider
            ]
        );
    }
}
