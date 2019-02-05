<?php

backend\

namespace app\modules\Users\models;



use Yii;



/**

 * This is the model class for table "bans".

 *

 * @property integer $id

 * @property string $userid

 * @property integer $banned

 * @property integer $endban

 * @property string $message

 *

 * @property Users $user

 */

class Bans extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'bans';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['id', 'userid'], 'required'],

            [['id', 'userid', 'banned', 'endban'], 'integer'],

            [['message'], 'string', 'max' => 255]

        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'userid' => Yii::t('app', 'Felhasználó'),

            'banned' => Yii::t('app', 'Tiltás ideje'),

            'endban' => Yii::t('app', 'Tiltás vége'),

            'message' => Yii::t('app', 'Tiltás oka'),

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

