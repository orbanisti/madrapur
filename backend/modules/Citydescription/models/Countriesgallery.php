<?php


namespace backend\modules\Citydescription\models;



use Yii;



/**

 * This is the model class for table "countries_gallery".

 *

 * @property integer $id
 * @property string $type
 * @property string $ownerId
 * @property integer $rank
 * @property string $name
 * @property string $description
 */

class Countriesgallery extends \yii\db\ActiveRecord
{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'countries_gallery';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [
            [['ownerId'], 'required'],
            [['rank'], 'integer'],
            [['description'], 'string'],
            [['type', 'ownerId', 'name'], 'string', 'max' => 255]
        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'ownerId' => Yii::t('app', 'Owner ID'),
            'rank' => Yii::t('app', 'Rank'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];

    }

}

