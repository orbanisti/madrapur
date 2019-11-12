<?php

namespace backend\modules\Payment\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Default model for the `Payment` module
 */
class Payment extends ActiveRecord {

    public static function tableName() {
        return 'modulusorders';
    }

    public function rules() {
        return [
            [['id'], 'integer'],
            [['source'], 'string', 'max' => 255],
            [['randomDate'], 'date', 'format' => 'yyyy-MM-dd'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'source' => Yii::t('app', 'Forrás'),
            'randomDate' => Yii::t('app', 'Véletlenszerű dátum'),
        ];
    }
}
