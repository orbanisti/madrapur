<?php

namespace backend\modules\Product\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;

/**
 * Default model for the `Product` module
 */
class ProductSource extends MadActiveRecord {

    public static function getProductSources($prodId) {

        $queryGetSources = ProductSource::aSelect(ProductSource::class, '*', ProductSource::tableName(), 'product_id=' . $prodId);
        try {
            $sourceRows = $queryGetSources->all();
            return $sourceRows;
        } catch (Exception $e) {
        }
    }
    public static function getProductSourcesIds($prodId) {


        $queryGetSources = ProductSource::aSelect(ProductSource::class, '*', ProductSource::tableName(), 'product_id=' . $prodId);


        try {
            $sourceRows = ProductSource::find()->andFilterWhere(
                ['=','product_id',$prodId]
            )->all();
            $ids=[];
            foreach ($sourceRows as $source){
                $ids[]=$source->prodIds;

            }

            return $ids;
        } catch (Exception $e) {
        }
    }

    public static function tableName() {
        return 'modulusProdSources';
    }

    public static function getProductSourceIds($prodId) {
        $queryGetSources = ProductSource::aSelect(ProductSource::class, '*', ProductSource::tableName(), 'product_id=' . $prodId);
        try {
            $sourceRows = $queryGetSources->all();

            $sourceRows = array_merge($sourceRows, ProductSource::addLocalSources($prodId));
            $sourceIdsArray = [];
            foreach ($sourceRows as $source) {
                $sourceIdsArray[] = $source->prodIds;
            }
            return $sourceIdsArray;
        } catch (Exception $e) {
        }
    }

    public static function addLocalSources($prodId) {
        $localsource1 = new ProductSource();
        $localsource2 = new ProductSource();
        $localsource3 = new ProductSource();
        $sourceRows = [];
        $localsource1->url = 'Hotel';
        $localsource1->prodIds = $prodId;
        $localsource2->url = 'Street';
        $localsource2->prodIds = $prodId;

        $localsource3->url = 'Madrapur';
        $localsource3->prodIds = $prodId;
        $sourceRows[] = $localsource1;
        $sourceRows[] = $localsource2;
        $sourceRows[] = $localsource3;
        return $sourceRows;
    }

    public static function getProductSourceUrls($prodId) {
        $queryGetSources = ProductSource::aSelect(ProductSource::class, '*', ProductSource::tableName(), 'product_id=' . $prodId);
        try {
            $sourceRows = $queryGetSources->all();
            $sourceIdsArray = [];
            foreach ($sourceRows as $source) {
                $sourceIdsArray[] = $source->url;
            }
            $finalArray = array_unique($sourceIdsArray);
            return $finalArray;
        } catch (Exception $e) {
        }
    }

    public function rules() {
        return [

            [['name'], 'required'],
            [['product_id', 'id'], 'integer'],
            [['name', 'url', 'prodIds', 'color'], 'string', 'max' => 100],

        ];
    }

    public function attributeLabels() {
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

    public function afterFind() {
        parent::afterFind();
        return true;
    }

}
