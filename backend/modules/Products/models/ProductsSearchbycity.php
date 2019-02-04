<?php
namespace backend\modules\Products\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Products\models\Products;
use backend\models\Shopcurrency;
use backend\components\Controller;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use backend\modules\Citydescription\models\Citydescription;
use backend\modules\Citydescription\models\CitydescriptionTranslate;
use backend\modules\Citydescription\models\Countries;
use backend\modules\Citydescription\models\Countriestranslate;
use backend\components\extra;

class ProductsSearchbycity extends Products
{
    public $minprice;
    public $maxprice;
    public $catlist;
    public $search;
    public $users;
    public $idlist;
    public $prodids;
    public $city;
    public $country;
    public $city_id;

    public function rules()
    {
        return [

            [['id', 'city_id', 'channel_id', 'status', 'source', 'category_id', 'time', 'max_participator', 'highlight', 'highlight_time', 'moderator_rating', 'classification', 'user_id'], 'integer'],
            [['search', 'name', 'intro', 'description', 'country', 'city', 'address', 'start_date', 'end_date', 'services', 'link'], 'safe'],
            [['price', 'minprice', 'maxprice'], 'number'],
            ['catlist', 'each', 'rule' => ['integer']],
            ['users', 'each', 'rule' => ['integer']],
            ['prodids', 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Products::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //Yii::$app->extra->e($this);

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'source' => $this->source,
            'category_id' => $this->category_id,
            'marketplace' => $this->marketplace,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'time' => $this->time,
            'max_participator' => $this->max_participator,
            'highlight' => $this->highlight,
            'highlight_time' => $this->highlight_time,
            'moderator_rating' => $this->moderator_rating,
            'classification' => $this->classification,
            'user_id' => $this->user_id,
            'channel_id' => $this->channel_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'services', $this->services])
            ->andFilterWhere(['like', 'link', $this->link])
            //->andFilterWhere(['>=', 'price', $this->minprice])
            //->andFilterWhere(['<=', 'price', $this->maxprice])
            ->andFilterWhere(['in', 'category_id', $this->catlist])
            ->andFilterWhere(['in', 'id', $this->idlist])
            ->andFilterWhere(['in', 'id', $this->prodids]);

        if(!empty($this->city_id)) {
            $cityprodids=ArrayHelper::map(Productscities::find()->where(['city_id'=>$this->city_id])->all(),'product_id','product_id');
            $query->andFilterWhere(['in', 'products.id', $cityprodids]);
        }

        //$query->orderBy(new Expression('rand()'));

        return $dataProvider;

    }

}

