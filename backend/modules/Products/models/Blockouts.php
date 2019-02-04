<?php



namespace backend\modules\Products\models;



use Yii;



/**

 * This is the model class for table "blockouts".

 *

 * @property integer $id

 * @property string $start_date

 * @property string $end_date

 * @property integer $product_id

 *

 * @property Products $product

 */

class Blockouts extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'blockouts';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['dates', 'product_id'], 'required'],

            [['product_id'], 'integer'],

            [['start_date','end_date'], 'date', 'format' => 'php:Y-m-d'],

            [['dates'], 'string', 'max' => 8000],

            //['start_date','validateDates'],

        ];

    }

    

    /*public function validateDates(){

        if(strtotime($this->end_date) < strtotime($this->start_date)){

            $this->addError('end_date','A befejező dátum, nem lehet régebbi a kezdődátumnál.');

        }

    }*/



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'start_date' => Yii::t('app', 'Kezdő dátum'),

            'end_date' => Yii::t('app', 'Befejező dátum'),

            'dates' => Yii::t('app', 'Dátumok'),

            'product_id' => Yii::t('app', 'Termék'),

        ];

    }



    /**

     * @return \yii\db\ActiveQuery

     */

    public function getProduct()

    {

        return $this->hasOne(Products::className(), ['id' => 'product_id']);

    }

}

