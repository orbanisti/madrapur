<?php
namespace frontend\controllers;

use backend\modules\Product\models\Product;
use common\models\Article;
use common\models\ArticleAttachment;
use frontend\models\Modorder;
use frontend\models\search\ArticleSearch;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\data\ActiveDataProvider;
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


        $searchModel=new Product();
        $query = Product::find()->andFilterWhere(['=','type','simple']);


        $dataProvider = new ActiveDataProvider([
                                                   'query' => $query,
                                               ]);
        $dataProvider->sort = [
            'defaultOrder' => [
                'id' => SORT_DESC
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

        if($slug=='cart'){
            $viewFile='cart';
            return $this->render($viewFile);

        }

        $model = Product::find()
            ->andWhere([
            'slug' => '/product/'.$slug
        ])
            ->one();

        if (! $model) {
            throw new NotFoundHttpException();
        }
        $viewFile = 'view';
        if($model->type=='simple'){
            $viewFile='simpleview';
            $cart=Yii::$app->cart;
            $tocart=new Modorder();
            if($tocart->load(Yii::$app->request->post() )&& $tocart->validate())
            {
                $product=Product::findOne($tocart->productId);
                $cart->add($product,1,$tocart->priceId);


                sessionSetFlashAlert('danger','Added to cart nigga');
                return $this->render($viewFile, [
                    'model' => $model,
                    'cart'=>$cart

                ]);

            }





        }
        return $this->render($viewFile, [
            'model' => $model,

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
