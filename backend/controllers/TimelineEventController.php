<?php
namespace backend\controllers;

use backend\models\search\TimelineEventSearch;
use Yii;
use backend\controllers\Controller;


/**
 * Application timeline controller
 */
class TimelineEventController extends \backend\controllers\Controller {

    public $layout = 'common';

    /**
     * Lists all TimelineEvent models.
     *
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TimelineEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => [
                'created_at' => SORT_DESC
            ]
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
