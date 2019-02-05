<?php

backend\

namespace app\modules\Users\models;



use Yii;



/**

 * This is the model class for table "user_partners".

 *

 * @property integer $id

 * @property integer $user_id

 * @property integer $partner_id

 */

class Userpartners extends \yii\db\ActiveRecord

{

    const RIGHT_ALL=2;

    const RIGHT_PRODUCTS_ORDERS=1;

    const RIGHT_ONLY_PRODUCTS=0;



    public static function rights($n=false)

    {

        $tt = [

            1 => Yii::t('app', 'Termékek és rendelések'),

            0 => Yii::t('app', 'Csak termékek'),

            2 => Yii::t('app', 'Minden'),

        ];

        return ($n===false)? $tt : $tt[$n];

    }

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'user_partners';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['partner_id', 'rights'], 'required'],

            [['user_id', 'partner_id', 'rights'], 'integer']

        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'user_id' => Yii::t('app', 'Felhasználó'),

            'partner_id' => Yii::t('app', 'Partner'),

            'rights' => Yii::t('app', 'Jogok'),

        ];

    }

    

    public function beforeSave($insert) {

        parent::beforeSave($insert);

        if($this->isNewRecord) $this->user_id=Yii::$app->user->id;

        return true;

    }



    public function getUser()

    {

        return $this->hasOne(Users::className(), ['id' => 'user_id']);

    }

    

    public function getPartner()

    {

        return $this->hasOne(Users::className(), ['id' => 'partner_id']);

    }

}

