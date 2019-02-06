<?php
namespace backend\modules\QRBase\models;

use Yii;
use yii\db\ActiveRecord;

class QRBase extends ActiveRecord {

    public static function tableName() {
        return 'mad_qrbase';
    }

    public function rules() {
        return [
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['sku'], 'string', 'max' => 255],
            [['claimed_on'], 'datetime', 'format' => 'yyyy-MM-dd HH:ii:ss'],
            [['hash'], 'string', 'max' => 150],
            [['views'], 'integer'],
            [['until'], 'date', 'format' => 'yyyy-MM-dd'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'name'),
            'sku' => Yii::t('app', 'sku'),
            'claimed_on' => Yii::t('app', 'Felhasználva'),
            'hash' => Yii::t('app', 'Hash'),
            'views' => Yii::t('app', 'Megtekintések'),
            'until' => Yii::t('app', 'Érvényes'),
        ];
    }

    public function afterFind() {
        parent::afterFind();

        if(Yii::$app->language != Yii::$app->sourceLanguage && !empty($this->translation))
            $this->attributes = $this->translation->attributes;
    }
}