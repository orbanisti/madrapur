<?php

namespace backend\modules\Seo\models;

use Yii;

/**
 * This is the model class for table "modulusseourl".
 *
 * @property int $id
 * @property int $projectId
 * @property string $url
 * @property string $data
 */
class Seourl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modulusseourl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['projectId'], 'integer'],
            [['url', 'data'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'projectId' => 'Project ID',
            'url' => 'Url',
            'data' => 'Data',
        ];
    }
}
