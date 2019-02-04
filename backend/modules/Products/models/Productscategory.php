<?php
namespace backend\modules\Products\models;

use Yii;
use backend\modules\Products\models\Productscategorytranslate;
use yii\helpers\ArrayHelper;
use backend\components\extra;

class Productscategory extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE=1;

    public static function status($n=false)
    {
        $tt = [
            1 => Yii::t('app', 'aktív'),
            0 => Yii::t('app', 'inaktív'),
        ];
        return ($n===false)? $tt : $tt[$n];
    }

    public static function tableName()
    {
        return 'products_category';
    }

    public function rules()
    {
        return [
            [['name', 'intro', 'status', 'parent_id'], 'required'],
            [['description'], 'string'],
            [['status', 'parent_id'], 'integer'],
            [['name', 'link'], 'string', 'max' => 255],
            [['intro'], 'string', 'max' => 500]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Név'),
            'intro' => Yii::t('app', 'Rövid leírás'),
            'description' => Yii::t('app', 'Leírás'),
            'status' => Yii::t('app', 'Státusz'),
            'link' => Yii::t('app', 'Link'),
            'parent_id' => Yii::t('app', 'Szülő kategória'),
        ];
    }

    public function beforeSave($insert)
    {
        $this->link = extra::stringToUrl($this->name);
        return true;
    }

    public static function getCategorytochk()
    {
        return ArrayHelper::map(self::find()->orderBy('name')->All(), 'id', 'name');
    }

    public static function getActivecategorytochk()
    {
        return ArrayHelper::map(Productscategory::find()->where("status=".Productscategory::STATUS_ACTIVE)->select('id,name')->asArray()->all(), 'id', 'name');
    }

    public function afterFind()
    {
        parent::afterFind();

        if(Yii::$app->language!=Yii::$app->sourceLanguage && !empty($this->translation))
            $this->attributes=$this->translation->attributes;
    }

    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['category_id' => 'id']);
    }

    public function getTranslations()
    {
        return $this->hasMany(Productscategorytranslate::className(), ['category_id' => 'id']);
    }

    public function getTranslation()
    {
        return Productscategorytranslate::findOne(['category_id' => $this->id, 'lang_code'=>Yii::$app->language]);
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    public static function getParentslisttoadmin()
    {
        $list=ArrayHelper::map(self::find()->where(['parent_id'=>0])->orderBy('name')->all(), 'id', 'name');
        $listp=[];
        $listp[0]=Yii::t('app','Főkategória');
        return ArrayHelper::merge($listp, $list);
    }

    public static function getParentslist()
    {
        $list=ArrayHelper::map(self::find()->where(['parent_id'=>0])->orderBy('name')->all(), 'id', 'name');
        $listp=[];
        $listp[0]=Yii::t('app','Főkategória');
        $parents=ArrayHelper::merge($listp, $list);
        $ret=ArrayHelper::map($parents, 'id', 'name');
        asort($ret,SORT_STRING);
        return $ret;
    }

    public static function getAllparents()
    {
        $db = Yii::$app->db;
        $parents = $db->cache(function ($db){
            return self::find()->where(['status'=>Products::STATUS_ACTIVE,'parent_id'=>0])->all();
        }, 60);
        $ret=ArrayHelper::map($parents, 'id', 'name');
        asort($ret,SORT_STRING);
        return $ret;
    }

    public static function getChildsbyid($id)
    {
        $db = Yii::$app->db;
        $childs = $db->cache(function ($db) use($id) {
            return self::find()->where(['status'=>Products::STATUS_ACTIVE,'parent_id'=>$id])->orderBy('name')->all();
        }, 60);
        $ret=ArrayHelper::map($childs, 'id', 'name');
        asort($ret,SORT_STRING);
        return $ret;
    }

    public static function getChildscountbyid($id)
    {
        $db = Yii::$app->db;
        $count = $db->cache(function ($db) use($id) {
            return self::find()->where(['status'=>Products::STATUS_ACTIVE,'parent_id'=>$id])->count();
        }, 60);
        return $count;
    }
}

