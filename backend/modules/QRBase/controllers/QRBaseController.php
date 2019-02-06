<?php
namespace backend\modules\QRBase\controllers;

use Yii;
use backend\controllers\Controller;
use backend\modules\QRBase\models\QRBaseAdminSearchModel;

/**
 * QRBaseController implements the CRUD actions for ReservationsModel.
 */
class QRBaseController extends Controller {
    public function actionAdmin() {
        $searchModel = new QRBaseAdminSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex() {
        $searchModel = new QRBaseAdminSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}