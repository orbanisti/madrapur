<?php

namespace backend\modules\Product\controllers;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use backend\modules\Product\models\Product;
use backend\modules\Reservations\models\Reservations;
use Yii;
use backend\controllers\Controller;
use backend\modules\Product\models\ProductUpdate;
use backend\modules\Product\models\ProductAdminSearchModel;

/**
 * Controller for the `Product` module
 */
class ProductController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        $searchModel = new ProductAdminSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);
    }
    public function actionCreate() {
        $model= new ProductUpdate();
        $request=YII::$app->request;

        $productUpdate = $request->post('ProductUpdate');
        $values=[
            'currency'=>$productUpdate['currency'],
            'status'=>$productUpdate['status'],
            'title'=>$productUpdate['name'],

            'short_description'=>$productUpdate['shortdescription'],
            'desctiption'=>$productUpdate['description'],
            'category'=>$productUpdate['category'],
            'capacity'=>$productUpdate['capacity'],
            'duration'=>$productUpdate['duration'],
            'image'=>$productUpdate['image'],
            'start_date'=>$productUpdate['start_date'],
            'end_date'=>$productUpdate['end_date'],
            ];
        $updateResponse='';
        if($productUpdate) {
            $newProduct=new Product();

            if (Product::insertOne($newProduct, $values)) {
                var_dump($values);
                $updateResponse = '<span style="color:green">Product Update Successful</span>';

            } else {
                $updateResponse = '<span style="color:red">Product Update Failed</span>';

                //show an error message
            }
        }
        return $this->render('create',['model'=>$model,'updateResponse'=>$updateResponse]);
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
