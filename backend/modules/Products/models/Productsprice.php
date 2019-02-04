<?php
namespace backend\modules\Products\models;

use Yii;
use backend\models\Shopcurrency;

class Productsprice extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'products_price';
    }

    public $nametranslate=[];
    public $descriptiontranslate=[];

    public function rules()
    {
        return [
            [['name','price'], 'required'],
            [['marketplace', 'marketplace_discount', 'product_id', 'status', 'participator'], 'integer'],
            [['price','net_price'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1000],
            ['nametranslate', 'each', 'rule' => ['string', 'max' => 255]],
            ['descriptiontranslate', 'each', 'rule' => ['string', 'max' => 1000]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'name' => Yii::t('app', 'Név'),
            'description' => Yii::t('app', 'Leírás'),
            'nametranslate' => Yii::t('app', 'Név'),
            'descriptiontranslate' => Yii::t('app', 'Leírás'),
            'net_price' => Yii::t('app', 'Nettó Ár'),
            'price' => Yii::t('app', 'Eladási Ár'),
            'status' => Yii::t('app', 'Státusz'),
            'participator' => Yii::t('app', 'Maximum résztvevő'),
            'marketplace' => Yii::t('app', 'Piactér'),
            'marketplace_discount' => Yii::t('app', 'Piactér kedvezmény').' ( % )',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        if((Yii::$app->controller->action->id!='myproducts' && Yii::$app->controller->action->id!='admin' && Yii::$app->controller->action->id!='update') && (Yii::$app->language!=$this->product->lang_code && !empty($this->translation)))
            $this->attributes=$this->translation->attributes;
        if(Yii::$app->controller->action->id!='myproducts' && Yii::$app->controller->action->id!='admin' && Yii::$app->controller->action->id!='update')
            $this->price=Shopcurrency::valueBycurrency($this->price, $this->product->currency);
    }

    public function getDprice(){
        $price=$this->price;
        if($this->product->marketplace==1){
            if($this->marketplace_discount!=0) {
                $price=$this->price*((100-$this->marketplace_discount)/100);
            } else {
                $price=$this->price*((100-$this->product->marketplace_discount)/100);
            }
        }
        //$price=($this->product->net_prices==1)?round($price*(1+(Yii::$app->params['tax']/100)),2):$price;
        return $price;
    }

    public function getDnetprice(){
        $price=$this->net_price;
        if($this->product->marketplace==1){
            if($this->marketplace_discount!=0) {
                $price=$this->net_price*((100-$this->marketplace_discount)/100);
            } else {
                $price=$this->net_price*((100-$this->product->marketplace_discount)/100);
            }
        }
        return $price;
    }

    public function beforeSave($insert) {
        parent::beforeSave($insert);

        if(empty($this->marketplace_discount)) $this->marketplace_discount=0;

        return true;
    }

    public function beforeDelete() {
        parent::beforeDelete();
        Productspricetranslate::deleteAll(['product_price_id'=>$this->id]);
        return true;
    }

    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    public function getProductpricetranslate()
    {
        return $this->hasOne(Productspricetranslate::className(), ['product_price_id' => 'id']);
    }

    public function getTranslation()
    {
        return Productspricetranslate::findOne(['product_price_id' => $this->id, 'lang_code'=>Yii::$app->language]);
    }

}

