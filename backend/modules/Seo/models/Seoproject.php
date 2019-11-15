<?php

namespace backend\modules\Seo\models;

use Yii;

/**
 * This is the model class for table "modulusseoproject".
 *
 * @property int $id
 * @property string $domain
 * @property string $title
 */
class Seoproject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modulusseoproject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain'], 'required'],
            [['title'], 'string'],
            [['domain'], 'string', 'max' => 50],
            [['domain'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Domain',
            'title' => 'Title',
        ];
    }
}
