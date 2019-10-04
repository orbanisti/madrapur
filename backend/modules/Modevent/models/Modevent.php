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
            [['title','place','user','status'], 'string', 'max' => 1200],
            [['date'], 'datetime', 'format' => 'yyyy-mm-dd H:i'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'title'),
            'place' => Yii::t('app', 'place'),
            'user' => Yii::t('app', 'user'),
            'status' => Yii::t('app', 'status'),
            'date' =>Yii::t('app', 'date')
        ];
    }
}
