<?php

namespace backend\modules\Seo\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Default model for the `Seo` module
 */
class Seo extends ActiveRecord {
 
    public static function tableName() {
        return 'modulusseo';
    }

    public function rules() {
        return [
            [['id'], 'integer'],
            [['postId'], 'integer'],
            [['postType'], 'string'],
            [['source'], 'string'],
            [['mainKeyword'], 'string'],
            [
                [
  
                    'meta+name+description',
                    'meta+name+keywords',
                    'meta+name+alternate',
                    'meta+name+canonical',
                    'meta+name+author',
                    'meta+name+news_keywords',

                    'meta+property+fb+pages',
                    'meta+property+og+type',
                    'meta+property+og+url',
                    'meta+property+og+title',
                    'meta+property+og+site_name',
                    'meta+property+og+locale',
                    'meta+property+og+updated_time',
                    'meta+property+og+description',
                    'meta+property+og+image+alt',
                    'meta+property+og+image',
                    'meta+property+article+publisher',

                    'meta+property+m+publication_local',
                    'meta+property+m+publication',
                ],
                'string'
            ],

        ];



    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'source' => Yii::t('app', 'Forrás'),
            'randomDate' => Yii::t('app', 'Véletlenszerű dátum'),
        ];
    }
}
