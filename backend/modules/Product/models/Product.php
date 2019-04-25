<?php

namespace backend\modules\Product\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Default model for the `Product` module
 */
class Product extends MadActiveRecord{
 
    public static function tableName() {
        return 'modulusProducts';
    }
//TODO
    public function rules() {
        return [
            [['id'], 'integer'],
            [['currency'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 255],
            [['thumbnail'], 'string', 'max' => 255],
            [['images'], 'string', 'max' => 255],
            [['category'], 'string', 'max' => 255],
            [['start_date'], 'string', 'max' => 255],
            [['end_date'], 'string', 'max' => 255],
            [['capacity'], 'string', 'max' => 255],
            [['duration'], 'string', 'max' => 255]
        ];
    }
//TODO
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'currency' => Yii::t('app', 'Currency'),
            'randomDate' => Yii::t('app', 'Véletlenszerű dátum'),
        ];
    }

    public static function getProdById($id){

//TODO get product from ID

        $query = Product::aSelect(Product::class, '*', Product::tableName(), 'id=' . $id);
        $prodInfo=0;
        try {
            $prodInfo = $query->one();


        } catch (Exception $e) {
        }

        return $prodInfo;

    }

    public static function getAllProducts() {
        $query = Product::aSelect(Product::class, '*', Product::tableName(), '1');

        $prodInfo = 0;

        try {
            $prodInfo = $query->all();
        } catch (Exception $e) {

        }

        return $prodInfo;

    }

    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        $models   = [];

        if (! empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }


}
