<?php

namespace backend\modules\Product\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;

/**
 * Default model for the `Product` module
 */
class ProductPrice extends MadActiveRecord {

    public static function tableName() {
        return 'modulusProductPrice';
    }
    public $Addons;

    public function rules() {
        return [

            [['name'], 'required'],
            [['product_id', 'id','price','hufPrice'], 'integer'],
            [['name', 'discount'], 'string', 'max' => 5000],
            [['description'], 'string', 'max' => 50000],
            [['start_date', 'end_date'], 'date', 'format' => 'yyyy-m-d'],

        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'discount' => Yii::t('app', 'Discount'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    public function init() {
        parent::init();

        return true;
    }

    public static function getAllPrices($id){
        $prices= ProductPrice::find()->andFilterWhere(['=','product_id',$id])->all();

        return $prices;
    }

    public static function priceExists($id,$price){

        $prices= ProductPrice::find()->andFilterWhere(['=','product_id',$id])->andFilterWhere(['=','price',$price])
            ->one();
        if($prices){
           return true;
        }else{
            return false;
        }


    }

    public function getProduct() {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function afterFind() {
        parent::afterFind();
        return true;
    }
    public static function eurtohuf($price){
        if($price->hufPrice){
            $price->price=$price->hufPrice;
            return $price;
        }
        else{
            $price->price=(int)$price->price*(int)Yii::$app->keyStorage->get('currency.huf-value');
            return $price;
        }
    }




    public static function eurtohufValue($price){
        $hufprice=$price*(int)Yii::$app->keyStorage->get('currency.huf-value');
        return $hufprice;
    }

}
