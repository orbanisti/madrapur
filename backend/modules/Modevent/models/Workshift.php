<?php

namespace backend\modules\Modevent\models;

use Yii;

/**
 * This is the model class for table "modulusworkshift".
 *
 * @property int $id
 * @property string $place
 * @property string $startTime
 * @property string $endTime
 * @property string $role
 */
class Workshift extends \backend\modules\MadActiveRecord\models\MadActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modulusWorkshift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['place', 'role'], 'string'],
            [['place', 'role','startTime', 'endTime'], 'required'],
            [['startTime', 'endTime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'place' => 'Place',
            'startTime' => 'Start Time',
            'endTime' => 'End Time',
            'role' => 'Role',
        ];
    }




}
