<?phpnamespace backend\modules\Products



namespace app\modules\Products\models;



use Yii;

use lajax\translatemanager\helpers\Language;

use app\modules\Products\models\Servicestranslate;

use yii\helpers\ArrayHelper;

use yii\helpers\Json;



/**

 * This is the model class for table "services".

 *

 * @property integer $id

 * @property string $name

 */

class Services extends \yii\db\ActiveRecord

{



    public $name_t;

    public $categorieslist=[];



    /**

     * @inheritdoc

     */

    public static function tableName()

    {

        return 'services';

    }



    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['name'], 'required'],

            [['name'], 'string', 'max' => 255],

            [['categories'], 'string', 'max' => 600],

            ['categorieslist', 'each', 'rule' => ['integer']],

        ];

    }



    /**

     * @inheritdoc

     */

    public function attributeLabels()

    {

        return [

            'id' => Yii::t('app', 'ID'),

            'name' => Yii::t('app', 'Név'),

            'categories' =>Yii::t('app', 'Kategóriák'),

            'categorieslist' =>Yii::t('app', 'Kategóriák'),

        ];

    }



    /*public function behaviors()

    {

        return [

            'translatebehavior' => [

                'class' => \lajax\translatemanager\behaviors\TranslateBehavior::className(),

                'translateAttributes' => ['name'],

                'category' => static::tableName(),

            ],

        ];

    }*/



    public function afterFind()

    {

        parent::afterFind();

        if(Yii::$app->language!=Yii::$app->sourceLanguage && !empty($this->translation))

            $this->attributes=$this->translation->attributes;



        $this->categorieslist=Json::decode($this->categories);

    }



    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {



            //Language::saveMessage($this->name, static::tableName());



            $this->categories=Json::encode($this->categorieslist);



            return true;

        }



        return false;

    }



    /**

     * @return string Returning the 'name' attribute on the site's own language.

     */

    /*public function getName($params = [], $language = null) {

        return Language::t(static::tableName(), $this->name, $params, $language);

    }*/



    public function getTranslations()

    {

        return $this->hasMany(Servicestranslate::className(), ['service_id' => 'id']);

    }



    public function getTranslation()

    {

        return Servicestranslate::findOne(['service_id' => $this->id, 'lang_code'=>Yii::$app->language]);

    }



    public static function getServicestochk()

    {

        return ArrayHelper::map(self::find()->All(), 'id', 'name');

    }



    public static function getServicesbyids($ids)

    {

        return self::find()->where(['id' => $ids])->orderBy('name')->all();

    }

}

