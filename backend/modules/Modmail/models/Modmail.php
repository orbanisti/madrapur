<?php

namespace backend\modules\Modmail\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Default model for the `Modmail` module
 */
class Modmail extends ActiveRecord {
 
    public static function tableName() {
        return 'modmail';
    }

    public function rules() {
        return [
            [['id'], 'integer'],
            [['type','from','to','status','subject'], 'string', 'max' => 255],
            [['body'], 'string', 'max' => 100000],
            [['date'], 'date', 'format' => 'yyyy-MM-dd'],
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
