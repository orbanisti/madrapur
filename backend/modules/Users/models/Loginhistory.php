<?php

backend\

namespace app\modules\Users\models;



use Yii;



/**

 * This is the model class for table "loginhistory".

 *

 * @property integer $id

 * @property integer $userid

 * @property string $login

 * @property string $ip

 * @property string $browser

 *

 * @property Users $user

 */

class Loginhistory extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'loginhistory';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['userid', 'ip', 'browser'], 'required'],

            [['userid'], 'integer'],

            [['login'], 'safe'],

            [['ip'], 'string', 'max' => 15],

            [['browser'], 'string', 'max' => 255]

        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'userid' => Yii::t('app', 'Felhazsnáló'),

            'login' => Yii::t('app', 'Időpont'),

            'ip' => Yii::t('app', 'IP'),

            'browser' => Yii::t('app', 'Böngésző'),

        ];

    }



    /**

     * @return \yii\db\ActiveQuery

     */

    public function getUser()

    {

        return $this->hasOne(Users::className(), ['id' => 'userid']);

    }

}

