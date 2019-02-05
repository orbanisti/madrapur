<?php

namespace backend\modules\Citydescription\models;

use Yii;
use backend\modules\Citydescription\models\CitydescriptionsightsTranslate;

/**
 * This is the model class for table "citydescription_sights".
 *
 * @property integer $id
 * @property integer $citydescription_id
 * @property string $name
 * @property string $description
 * @property integer $sort_order
 * @property integer $image_id
 *
 * @property Citydescription $citydescription
 */
class Citydescriptionsights extends \yii\db\ActiveRecord
{
    public $deleteImg;
    public $nametranslate=[];
    public $descriptiontranslate=[];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'citydescription_sights';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['citydescription_id', 'sort_order', 'deleteImg'], 'integer'],
            [['name', 'image'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 1500],
            ['nametranslate', 'each', 'rule' => ['string', 'max' => 200]],
            ['descriptiontranslate', 'each', 'rule' => ['string', 'max' => 1500]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'citydescription_id' => Yii::t('app', 'Város'),
            'name' => Yii::t('app', 'Név'),
            'description' => Yii::t('app', 'Leírás'),
            'nametranslate' => Yii::t('app', 'Név'),
            'descriptiontranslate' => Yii::t('app', 'Leírás'),
            'sort_order' => Yii::t('app', 'Sorrend'),
            'image' => Yii::t('app', 'Kép'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitydescription()
    {
        return $this->hasOne(Citydescription::className(), ['id' => 'citydescription_id']);
    }

    public function getThumb()
    {
        if($this->image!='' && file_exists(WEB_ROOT.Yii::$app->params['citiessightsPictures'].$this->image))
            return Yii::$app->imagecache->createUrl('citysights-thumb',Yii::$app->params['citiessightsPictures'].$this->image);
        else
            return Yii::$app->params['citiessightsPictures'].'no-pic-thumb.png';
    }

    public function afterFind()
    {
        parent::afterFind();

        if(Yii::$app->language!=Yii::$app->sourceLanguage && !empty($this->translation))
            $this->attributes=$this->translation->attributes;
    }

    public function beforeDelete() {
        parent::beforeDelete();
        CitydescriptionsightsTranslate::deleteAll(['citydescription_sights_id'=>$this->id]);
        return true;
    }

    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    public function getCitydescriptionsightstranslate()
    {
        return $this->hasOne(CitydescriptionsightsTranslate::className(), ['citydescription_sights_id' => 'id']);
    }

    public function getTranslation()
    {
        return CitydescriptionsightsTranslate::findOne(['citydescription_sights_id' => $this->id, 'lang_code'=>Yii::$app->language]);
    }

}
