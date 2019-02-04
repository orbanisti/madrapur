<?php

namespace backend\modules\Products

namespace app\modules\Products\models;



use Yii;



/**

 * This is the model class for table "description_list".

 *

 * @property integer $id

 * @property string $name

 * @property integer $list_category_id

 *

 * @property DescriptionListCategory $listCategory

 */

class Descriptionlist extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'description_list';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['name', 'list_category_id'], 'required'],

            [['list_category_id'], 'integer'],

            [['name'], 'string', 'max' => 255]

        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'name' => Yii::t('app', 'Name'),

            'list_category_id' => Yii::t('app', 'List Category ID'),

        ];

    }



    /**

     * @return \yii\db\ActiveQuery

     */

    public function getListCategory()

    {

        return $this->hasOne(DescriptionListCategory::className(), ['id' => 'list_category_id']);

    }

}

