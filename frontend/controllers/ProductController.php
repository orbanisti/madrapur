<?php
namespace frontend\controllers;

use backend\modules\Product\models\Product;
use common\models\Article;
use common\models\ArticleAttachment;
use frontend\models\search\ArticleSearch;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 *
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ProductController extends Controller {

    /**
     *
     * @return string
     */
    public function actionIndex() {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => [
                'created_at' => SORT_DESC
            ]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     *
     * @param
     *            $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug) {
        $model = Product::find()
            ->andWhere([
            'slug' => $slug
        ])
            ->one();
        if (! $model) {
            throw new NotFoundHttpException();
        }
        $viewFile = 'view';
        return $this->render($viewFile, [
            'model' => $model
        ]);
    }


    /**
     *
     * @param
     *            $id
     * @return $this
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionAttachmentDownload($id) {
        $model = ArticleAttachment::findOne($id);
        if (! $model) {
            throw new NotFoundHttpException();
        }

        return Yii::$app->response->sendStreamAsFile(Yii::$app->fileStorage->getFilesystem()
            ->readStream($model->path), $model->name);
    }
}
