<?php
namespace common\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use common\models\query\PageQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Page extends MadActiveRecord {

    const STATUS_DRAFT = 0;

    const STATUS_PUBLISHED = 1;

    /**
     *
     * @inheritdoc
     */
    public static function tableName() {
        return 'page';
    }

    /**
     *
     * @return PageQuery
     */
    public static function find() {
        return new PageQuery(get_called_class());
    }

    /**
     *
     * @return array statuses list
     */
    public static function statuses() {
        return [
            self::STATUS_DRAFT => Yii::t('common', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('common', 'Published'),
        ];
    }

    /**
     *
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::class,
            'slug' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'ensureUnique' => true,
                'immutable' => true
            ]
        ];
    }

    /**
     *
     * @inheritdoc
     */
    public function rules() {
        return [
            [
                [
                    'title'
                ],
                'required'
            ],
            [
                [
                    'body',

                    'meta:name:description',
                    'meta:name:keywords',
                    'meta:name:alternate',
                    'meta:name:canonical',
                    'meta:name:author',
                    'meta:name:news_keywords',

                    'meta:property:fb:pages',
                    'meta:property:og:type',
                    'meta:property:og:url',
                    'meta:property:og:title',
                    'meta:property:og:site_name',
                    'meta:property:og:locale',
                    'meta:property:og:updated_time',
                    'meta:property:og:description',
                    'meta:property:og:image:alt',
                    'meta:property:og:image',
                    'meta:property:article:publisher',

                    'meta:property:m:publication_local',
                    'meta:property:m:publication',
                ],
                'string'
            ],
            [
                [
                    'status'
                ],
                'integer'
            ],
            [
                [
                    'slug'
                ],
                'unique'
            ],
            [
                [
                    'slug'
                ],
                'string',
                'max' => 2048
            ],
            [
                [
                    'title'
                ],
                'string',
                'max' => 512
            ],
        ];
    }

    /**
     *
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => Yii::t('common', 'Slug'),
            'title' => Yii::t('common', 'Title'),
            'body' => Yii::t('common', 'Body'),
            'view' => Yii::t('common', 'Page View'),
            'status' => Yii::t('common', 'Active'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}
