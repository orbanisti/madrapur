<?php

namespace backend\modules\Product\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Default model for the `Product` module
 */
class Product extends MadActiveRecord {

    const ACCESS_PRODUCT_ADMIN = 'viewProductAdmin';
    const CREATE_PRODUCT = 'createProduct';
    const UPDATE_PRODUCT = 'updateProduct';
    const UPDATE_OWN_PRODUCT = 'updateOwnProduct';
    const ACCESS_TIME_TABLE = 'accessTimeTable';
    const BLOCK_DAYS = 'blockDays';
    const BLOCK_TIMES = 'blockTimes';

    const LOCAL_SOURCES=['Hotel','Street'];

    public $picture;

    public function behaviors() {
        return [
            'picture' => [
                'class' => UploadBehavior::class,
                'attribute' => 'picture',
                'pathAttribute' => 'thumbnail',
                'baseUrlAttribute' => 'thumbnailBase'
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ],
        ];
    }
    public static function getAddons($id){
        $productAddons=[];

        $addOnLinks = ProductAddOn::find()
            ->andFilterWhere(['=', 'prodId', $id])
            ->all();
        foreach ($addOnLinks as $i => $addOnLink) {
            $addOn = AddOn::findOne(['id' => $addOnLink->addOnId, 'type' => 'simple']);
            if ($addOn) {
                $productAddons[$addOn->id]=$addOn->name;


            }
        }
        return $productAddons;
    }

    public  function getPrices(){

        $productPrices=ProductPrice::find()->andFilterWhere(['=','product_id',$this->id])->all();

        $priceNameArray=ArrayHelper::map($productPrices,'id','name');
        return $priceNameArray;


    }




    public static function getAllProducts() {

        $where = self::andWhereFilter([
            ['id', '!=', '0'],
            ['isDeleted', '!=', "yes"],

        ]);
        $query = Product::aSelect(Product::class, '*', Product::tableName(), $where);

        $prodInfo = 0;

        try {
            $prodInfo = $query->all();
            foreach ($prodInfo as $i => $prod) {
                $prodInfo[$i] = Product::getProdById($prod->id);
            }
        } catch (Exception $e) {

        }

        return $prodInfo;
    }

    public static function getStreetProducts() {

        $where = self::andWhereFilter([
                                          ['id', '!=', '0'],
                                          ['isDeleted', '!=', "yes"],
                                          ['isStreet', '=', "yes"],
                                      ]);
        $query = Product::aSelect(Product::class, '*', Product::tableName(), $where);

        $prodInfo = 0;

        try {
            $prodInfo = $query->all();
            foreach ($prodInfo as $i => $prod) {
                $prodInfo[$i] = Product::getProdById($prod->id);
            }
        } catch (Exception $e) {

        }

        return $prodInfo;
    }


//TODO

    public static function tableName() {
        return 'modulusProducts';
    }


    public static function getProductName(){




    }

//TODO

    public static function getProdById($id) {

//TODO get product from ID

        $query = Product::aSelect(Product::class, '*', Product::tableName(), 'id=' . $id);
        $queryTimes = Product::aSelect(ProductTime::class, '*', ProductTime::tableName(), '1');
        $queryPrices = Product::aSelect(ProductPrice::class, '*', ProductPrice::tableName(), '1');
        $allTimes = $queryTimes->all();
        $allPrices = $queryPrices->all();

        $prodInfo = new Product();
        try {
            $prodInfo = $query->one();
            if($prodInfo){

                $thisProdTimes = [];
                foreach ($allTimes as $time) {
                    if ($time->product_id == $id) {

                        $thisProdTimes[] = $time;
                    }
                }
                $prodInfo->setAttribute("times", $thisProdTimes);
                $thisProdPrice = [];
                foreach ($allPrices as $price) {
                    if ($price->product_id == $id) {
                        $thisProdPrice[] = $price;
                    }
                }
                $prodInfo->setAttribute("prices", $thisProdPrice);

            }

        } catch (Exception $e) {
        }

        return $prodInfo;
    }




    public static function createMultiple($modelClass, $multipleModels = []) {
        $model = new $modelClass;
        $formName = $model->formName();
        $post = Yii::$app->request->post($formName);
        $models = [];

        if (!empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }

    public static function searchSourceName($sourceID, $sourceUrl) {
        /**
         * Returns source name
         */
        $what = ['*'];
        $from = ProductSource::tableName();
        $wheres = [];
        $wheres[] = ['prodIds', '=', $sourceID];
        $wheres[] = ['url', '=', Html::encode($sourceUrl)];

        $where = self::andWhereFilter($wheres);

        $rows = self::aSelect(ProductSource::class, $what, $from, $where);

        $myreturned = $rows->one();
        if (isset($myreturned->name)) {

            return $myreturned->name;
        } else {
            return null;
        }
    }

    public function rules() {
        return [
            [['id'], 'integer'],
            [['currency'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 255],
            [['title','shortName','cCode'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 20000],
            [['short_description'], 'string', 'max' => 5000],
            [['thumbnail'], 'string', 'max' => 255],
            [['images'], 'string', 'max' => 255],
            [['category'], 'string', 'max' => 255],
            [['start_date'], 'string', 'max' => 255],
            [['end_date'], 'string', 'max' => 255],
            [['capacity'], 'string', 'max' => 255],
            [['duration'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 255],
            [['isDeleted'], 'string', 'max' => 10],
            [['isStreet'], 'string', 'max' => 10],
            [['type'],'safe'],
            [['start_date','times','title'],'required'],
            [
                'picture',
                'safe'
            ]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'currency' => Yii::t('app', 'Currency'),
            'randomDate' => Yii::t('app', 'Véletlenszerű dátum'),
        ];
    }

    public function attributes() {
        $attributes = parent::attributes();
        return array_merge($attributes, [
            'times', 'prices'
        ]);
    }

    public function getPricesDetails() {
        return $this->prices;
    }

    public function setPricesDetails($orderDetails) {
        $this->prices = $orderDetails;
    }

    public function getTimesDetails() {
        return $this->times;
    }

    public function setTimesDetails($orderDetails) {
        $this->times = $orderDetails;
    }

    public function getProdUrl() {
        return $this->times;
    }

    public function setProdUrl($orderDetails) {
        $this->times = $orderDetails;
    }

    public function afterFind() {
        if(!isset($this->shortName)){
            $this->shortName=$this->title;
        }

        if (!isset($this->isDeleted)) {
            $this->isDeleted = 'no';
            $this->save('false');
        }
       parent::afterFind(); // TODO: Change the autogenerated stub
    }

}
