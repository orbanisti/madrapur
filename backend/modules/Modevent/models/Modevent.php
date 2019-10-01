<?php

namespace backend\modules\Modevent\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Yii;
use yii\db\ActiveRecord;

/**
 * Default model for the `Modevent` module
 */
class Modevent extends MadActiveRecord{
 
    public static function tableName() {
        return 'modulusModevent';
    }

    public function rules() {
        return [
            [['id'], 'integer'],
            [['title','place'], 'string', 'max' => 1200],
            [['start','end'], 'date', 'format' => 'yyyy-mm-dd H:i'],
        ];
    }

    public function attributeLabels() {
        return [
//            'id' => Yii::t('app', 'ID'),
//            'source' => Yii::t('app', 'Forrás'),
//            'randomDate' => Yii::t('app', 'Véletlenszerű dátum'),
        ];
    }
}
