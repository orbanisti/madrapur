<?php

namespace backend\modules\Product\controllers;


use backend\modules\Product\models\Product;
use backend\modules\Product\models\ProductEdit;

use backend\modules\Product\models\ProductPrice;
use backend\modules\Reservations\models\Reservations;
use Yii;
use backend\controllers\Controller;
use backend\modules\Product\models\ProductUpdate;
use backend\modules\Product\models\ProductTime;

use backend\modules\Product\models\ProductAdminSearchModel;
use yii\helpers\ArrayHelper;

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

                $updateResponse = '<span style="color:green">Product Update Successful</span>';

            } else {
                $updateResponse = '<span style="color:red">Product Update Failed</span>';

                //show an error message
            }
        }
        return $this->render('create',['model'=>$model,'updateResponse'=>$updateResponse]);
    }

    /**
     * @return string
     */
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



        /*******************Times Rész /TODO bring this to manly form*********************/


        $request=YII::$app->request;
        $productPostedTimes = $request->post('ProductTime');
        $modelTimes[]=new ProductTime();






        //$deletedtimesIDs = array_diff($rowsArray, ));
      //  var_dump($deletedtimesIDs);




        if($productPostedTimes) {
            $queryGetTimes = ProductTime::aSelect(ProductTime::class, '*', ProductTime::tableName(), 'product_id=' .$prodId);
            try {
                $rowsAll = $queryGetTimes->all();
            } catch (Exception $e) {
            }

            $rowsArray=ArrayHelper::toArray($rowsAll);
            $a=array_filter(ArrayHelper::map($rowsArray, 'id', 'id'));
            $b=array_filter(ArrayHelper::map($productPostedTimes, 'id', 'id'));


            $deletedTimesIds=array_diff($a,$b);
            if (! empty($deletedTimesIds)) {
                ProductTime::deleteAll(['id' => $deletedTimesIds]);
            }
            foreach($productPostedTimes as $postedTime):


            if($postedTime['start_date']=='NULL' ||$postedTime['start_date']=='' ){
                $postedTime['start_date']=date("Y-m-d");
            }
                if($postedTime['end_date']=='NULL' ||$postedTime['end_date']=='' ){
                    $postedTime['end_date']=date("Y-m-d");
                }
            $values=[
                    'name'=>$postedTime['name'],
                    'start_date'=>$postedTime['start_date'],
                    'end_date'=>$postedTime['end_date'],
                    'product_id'=>$prodId,
                    'id'=>$postedTime['id']
                ];


            $query = ProductTime::aSelect(ProductTime::class, '*', ProductTime::tableName(), 'product_id=' .$prodId.' and id="'.$values['id'].'"');

                try {
                    $rows = $query->one();

                } catch (Exception $e) {
                }
                if (isset($rows)) {
                    $newTimes=$rows;
                    //letezao productot updatelunk
                } else {
                    $newTimes=new ProductTime();


                }


                if (Product::insertOne($newTimes, $values)) {
                    $updateResponse = 1;

                } else {
                    $updateResponse = 0;

                    //show an error message
                }


            endforeach;



        }

        $queryGetTimes = ProductTime::aSelect(ProductTime::class, '*', ProductTime::tableName(), 'product_id=' .$prodId);
        try {
            $rowsAll = $queryGetTimes->all();
        } catch (Exception $e) {
        }

        if (isset($rowsAll)) {

            if(!$productPostedTimes && $productEdit){
                if(isset($rowsAll[0])) {
                    $deletedTimesIds[$rowsAll[0]['id']] = $rowsAll[0]['id'];
                    var_dump($deletedTimesIds);
                    $resultofdeletingTimes = ProductTime::deleteAll(['id' => $deletedTimesIds]);
                    var_dump($resultofdeletingTimes);

                    $rowsAll = $queryGetTimes->all();
                }
            }
                    $modelTimes=$rowsAll;






        }
        else{
            $modelTimes[]=new ProductTime();
            $modelTimes = Product::createMultiple(ProductTime::className(),$modelTimes);
            $modelTimes[0]=new ProductTime();
            $modelTimes[0]->start_date=date("Y-m-d");
        }

        /*******************Prices Rész /TODO bring this to manly form*********************/


        $request=YII::$app->request;
        $productPostedPrices = $request->post('ProductPrice');
        $modelPrices[]=new ProductPrice();



        if($productPostedPrices) {
            $queryGetPrices = ProductPrice::aSelect(ProductPrice::class, '*', ProductPrice::tableName(), 'product_id=' .$prodId);
            try {
                $rowsAll = $queryGetPrices->all();
            } catch (Exception $e) {
            }

            $rowsArray=ArrayHelper::toArray($rowsAll);
            $a=array_filter(ArrayHelper::map($rowsArray, 'id', 'id'));
            $b=array_filter(ArrayHelper::map($productPostedPrices, 'id', 'id'));


            $deletedPricesIds=array_diff($a,$b);



            $result=ProductPrice::deleteAll(['id' => $deletedPricesIds]);

            foreach($productPostedPrices as $postedPrice):




                $values=[
                    'name'=>$postedPrice['name'],
                    'description'=>$postedPrice['description'],
                    'discount'=>$postedPrice['discount'],
                    'price'=>$postedPrice['price'],
                    'product_id'=>$prodId,
                    'id'=>$postedPrice['id']
                ];



                $query = ProductPrice::aSelect(ProductPrice::class, '*', ProductPrice::tableName(), 'product_id=' .$prodId.' and id="'.$values['id'].'"');

                try {
                    $rows = $query->one();

                } catch (Exception $e) {
                }
                if (isset($rows)) {
                    $newPrice=$rows;
                    //letezao productot updatelunk
                } else {
                    $newPrice=new ProductPrice();


                }


                if (Product::insertOne($newPrice, $values)) {
                    $updateResponse = 1;

                } else {
                    $updateResponse = 0;

                    //show an error message
                }


            endforeach;



        }

        $queryGetPrices= ProductPrice::aSelect(ProductPrice::class, '*', ProductPrice::tableName(), 'product_id=' .$prodId);
        try {
            $rowsAll = $queryGetPrices->all();
        } catch (Exception $e) {
        }

        if (isset($rowsAll)) {


            if(!$productPostedPrices && $productEdit){
                if(isset($rowsAll[0])) {
                    $deletedPricesIds[$rowsAll[0]['id']] = $rowsAll[0]['id'];
                    var_dump($deletedPricesIds);
                    $resultofdeletingPrices = ProductPrice::deleteAll(['id' => $deletedPricesIds]);
                    var_dump($resultofdeletingPrices);

                    $rowsAll = $queryGetPrices->all();
                }
            }
            $modelPrices=$rowsAll;
        }

        else{
            $modelPrices[]=new ProductPrice();
            $modelPrices = Product::createMultiple(ProductPrice::class,$modelTimes);
            $modelPrices[0]=new ProductPrice();
            $modelPrices[0]->name='asd';

        }

        /**
         * This is for the booking Table
         *  TODO Ajax this
         *
         *
         */

        $queryGetReservatios= Product::aSelect(Reservations::class, '*', Reservations::tableName(), 'product_id=' .$prodId);
        try {
            $rowsAll = $queryGetPrices->all();
        } catch (Exception $e) {
        }

        if (isset($rowsAll)) {













        return $this->render('update',['model'=>$model,'backendData'=>$backendData,'updateResponse'=>$updateResponse,'prodId'=>$prodId,'modelTimes'=>((empty($modelTimes)) ? [new ProductTime()] : $modelTimes),'modelPrices'=>(empty($modelPrices)) ? [new ProductPrice()] : $modelPrices]);

    }






    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
