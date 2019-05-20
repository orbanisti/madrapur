<?php

namespace backend\modules\Product\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;
use yii\db\ActiveRecord;

/**
 * Default model for the `Product` module
 */
class ProductSource extends MadActiveRecord{

    public static function tableName()
    {
        return 'modulusProdSources';
    }

    public function rules()
    {
        return [

            [['name'], 'required'],
            [['product_id','id'], 'integer'],
            [['name','url','prodIds','color'], 'string', 'max' => 100],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Site Url:'),
            'color' => Yii::t('app', 'Color:'),
            'prodIds' => Yii::t('app', 'Product Id'),
        ];
    }

    public function init() {
        parent::init();



        return true;
    }

    public static function getProductSources($prodId)

    {

        $queryGetSources = ProductSource::aSelect(ProductSource::class, '*', ProductSource::tableName(), 'product_id=' . $prodId);
        try {
            $sourceRows = $queryGetSources->all();
            return $sourceRows;
        } catch (Exception $e) {
        }

    }

    public static function getProductSourceIds($prodId){
        $queryGetSources = ProductSource::aSelect(ProductSource::class, '*', ProductSource::tableName(), 'product_id=' . $prodId);
        try {
            $sourceRows = $queryGetSources->all();
            $sourceIdsArray=[];
            foreach ($sourceRows as $source) {
                $sourceIdsArray[]=$source->prodIds;

            }
            return $sourceIdsArray;

        } catch (Exception $e) {
        }


        }
    public static function getProductSourceUrls($prodId){
        $queryGetSources = ProductSource::aSelect(ProductSource::class, '*', ProductSource::tableName(), 'product_id=' . $prodId);
        try {
            $sourceRows = $queryGetSources->all();
            $sourceIdsArray=[];
            foreach ($sourceRows as $source) {
                $sourceIdsArray[]=$source->url;

            }
            $finalArray=array_unique($sourceIdsArray);
            return $finalArray;

        } catch (Exception $e) {
        }


    }



    public function afterFind() {
        parent::afterFind();
        return true;
    }

}
