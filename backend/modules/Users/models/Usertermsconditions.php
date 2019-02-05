<?php

namespace backend\modules\Users\models;

use Yii;
use backend\modules\Users\models\Usertermsconditionstranslate;

/**
 * This is the model class for table "user_terms_conditions".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $content
 * @property string $lang_code
 */
class Usertermsconditions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_terms_conditions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'lang_code'], 'required'],
            [['user_id'], 'integer'],
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
            'user_id' => Yii::t('app', 'User ID'),
            'content' => Yii::t('app', 'Tartalom'),
            'lang_code' => Yii::t('app', 'Nyelv'),
        ];
    }
    
    public function getTranslations()
    {
        return $this->hasMany(Usertermsconditionstranslate::className(), ['user_tc' => 'id']);
    }

    public function getTranslation()
    {
        return Usertermsconditionstranslate::findOne(['user_tc' => $this->id, 'lang_code'=>Yii::$app->language]);
    }
    
    public function afterFind()
    {
        parent::afterFind();

        //if((Yii::$app->controller->action->id!='update' && Yii::$app->controller->action->id!='create' && Yii::$app->controller->action->id!='delete') && Yii::$app->language!=Yii::$app->sourceLanguage && !empty($this->translation))
        if(Yii::$app->language!=$this->lang_code && !empty($this->translation))
            $this->attributes=$this->translation->attributes;
    }
}
