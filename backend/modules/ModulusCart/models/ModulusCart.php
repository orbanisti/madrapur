<?php

namespace backend\modules\ModulusCart\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Default model for the `ModulusCart` module
 */
class ModulusCart extends ActiveRecord {
 
    public static function tableName() {
        return 'modulusCarts';
    }

    public function rules() {
        return [
            [['id'], 'integer'],
            [['items'], 'string', 'max' => 50000],
            [['createDate'], 'date', 'format' => 'yyyy-MM-dd'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'items' => Yii::t('app', 'Cart items'),
            'randomDate' => Yii::t('app', 'Create Date'),
        ];
    }
}
