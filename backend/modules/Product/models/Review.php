<?php

namespace backend\modules\Product\models;

use Yii;

/**
 * This is the model class for table "modulusreviews".
 *
 * @property int $id
 * @property int $prodId
 * @property string $author
 * @property string $source
 * @property string $content
 * @property string $date
 * @property double $rating
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modulusreviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'prodId'], 'integer'],
            [['author', 'source', 'content'], 'string'],
            [['date'], 'safe'],
            [['rating'], 'number'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prodId' => 'Prod ID',
            'author' => 'Author',
            'source' => 'Source',
            'content' => 'Content',
            'date' => 'Date',
            'rating' => 'Rating',
        ];
    }
}
