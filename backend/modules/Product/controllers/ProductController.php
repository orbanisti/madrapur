<?php

namespace backend\modules\Product\controllers;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use backend\modules\Product\models\Product;
use backend\modules\Product\models\ProductEdit;
use backend\modules\Reservations\models\Reservations;
use Yii;
use backend\controllers\Controller;
use backend\modules\Product\models\ProductUpdate;
use backend\modules\Product\models\ProductTime;

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
            'title'=>$productUpdate['title'],

            'short_description'=>$productUpdate['short_description'],
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

    public function actionUpdate(){

        $model=new ProductEdit();
        $request=Yii::$app->request;
        $prodId=$request->get('prodId');

        $query = Product::aSelect(Product::class, '*', Product::tableName(), 'id=' . $prodId);

        try {
            $prodInfo = $query->one();
        } catch (Exception $e) {
        }
        $backendData=$prodInfo;

        //here I update my model to contain info from the DB to populate the FORM but it's important that you use a Model like Product at the selection so you don't redeclare stuff
        $model=$backendData;


        $request=YII::$app->request;

        $productEdit = $request->post('Product');

        $updateResponse='Empty Response';

        if($productEdit) {

            $values=[
                'currency'=>$productEdit['currency'],
                'status'=>$productEdit['status'],
                'title'=>$productEdit['title'],
                'short_description'=>$productEdit['short_description'],
                'description'=>$productEdit['description'],
                'category'=>$productEdit['category'],
                'capacity'=>$productEdit['capacity'],
                'duration'=>$productEdit['duration'],
                'images'=>$productEdit['images'],
                'start_date'=>$productEdit['start_date'],
                'end_date'=>$productEdit['end_date'],
            ];



            $query = Product::aSelect(Product::class, '*', Product::tableName(), 'id=' .$prodId);

            try {
                $rows = $query->one();
            } catch (Exception $e) {
            }
            if (isset($rows)) {
                $newProduct = $rows;
                //letezao productot updatelunk
            } else {
                $newProduct=new Product();

            }


            if (Product::insertOne($newProduct, $values)) {
                $updateResponse = 1;

            } else {
                $updateResponse = 0;

                //show an error message
            }
        }
        if($updateResponse==1){
            $query = Product::aSelect(Product::class, '*', Product::tableName(), 'id=' . $prodId);
            try {
                $prodInfo = $query->one();

                $model=$prodInfo;
            } catch (Exception $e) {
            }


        }
        $productModelTime=new ProductTime();

        $modelTimes[]=new ProductTime();
        $modelTimes = Product::createMultiple(ProductTime::className(),$modelTimes);
        $modelTimes[0]=new ProductTime();
        $modelTimes[0]->start_date='2019-04-10';





        return $this->render('update',['model'=>$model,'backendData'=>$backendData,'updateResponse'=>$updateResponse,'prodId'=>$prodId,'modelTimes'=>$modelTimes]);

    }






    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
