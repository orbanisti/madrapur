<?php

namespace backend\modules\Users\models;

use Yii;

/**
 * This is the model class for table "user_terms_conditions_translate".
 *
 * @property integer $id
 * @property integer $user_tc
 * @property string $content
 * @property string $lang_code
 */
class Usertermsconditionstranslate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_terms_conditions_translate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['user_tc', 'content', 'lang_code'], 'required'],
            [['user_tc'], 'integer'],
            [['content'], 'string'],
            [['lang_code'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_tc' => Yii::t('app', 'User Tc'),
            'content' => Yii::t('app', 'Tartalom'),
            'lang_code' => Yii::t('app', 'Nyelv'),
        ];
    }
}
