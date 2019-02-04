<?phpnamespace backend\modules\Products

namespace app\modules\Products\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Products\models\Products;
use app\models\Shopcurrency;
use app\components\Controller;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use app\modules\Citydescription\models\Citydescription;
use app\modules\Citydescription\models\CitydescriptionTranslate;
use app\modules\Citydescription\models\Countries;
use app\modules\Citydescription\models\Countriestranslate;
use app\components\extra;

class ProductsSearch extends Products
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

    public function rules()
    {
        return [

            [['id', 'channel_id', 'status', 'source', 'category_id', 'time', 'max_participator', 'highlight', 'highlight_time', 'moderator_rating', 'classification', 'user_id'], 'integer'],
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

        //$query->joinWith(['translation']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=> ['defaultOrder' => ['name'=>SORT_ASC]],
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

        //extra::e($params);
        $query->andFilterWhere(['or',['like', 'name', $this->search],['like', 'description', $this->search],['like', 'other_info', $this->search]]);

        $minprice=[]; $maxprice=[];

        //Yii::$app->extra->e($dataProvider);
        $minprice[0]='or'; $maxprice[0]='or'; $i=0;
        foreach (Shopcurrency::getAvaibleCurrencies() as $curr)
        {
            $i++;
            if($this->minprice!='') {
                $mp=[];
                $mp[]='and';
                $mp[]=['>=', 'price', Shopcurrency::valueBycurrency($this->minprice, Controller::$currency,$curr->sort_name)];
                $mp[]=['=','currency',$curr->sort_name];
                $minprice[$i]=$mp;
            }
            if($this->maxprice!='') {
                $mp=[];
                $mp[]='and';
                $mp[]=['<=', 'price', Shopcurrency::valueBycurrency($this->maxprice, Controller::$currency,$curr->sort_name)];
                $mp[]=['=','currency',$curr->sort_name];
                $maxprice[$i]=$mp;
            }
        }
        //Yii::$app->extra->e($minprice);
        $query->andFilterWhere($minprice);
        $query->andFilterWhere($maxprice);

        if(!empty($this->city)) {
            if(Yii::$app->language!=Yii::$app->sourceLanguage) {
                $cities=ArrayHelper::map(CitydescriptionTranslate::find()->where('`title` LIKE "%'.$this->city.'%" AND `lang_code`="'.Yii::$app->language.'"')->all(), 'citydescription_id', 'citydescription_id');
                if(empty($cities))
                    $cities=ArrayHelper::map(Citydescription::find()->where('`title` LIKE "%'.$this->city.'%"')->all(), 'id', 'id');
            } else {
                $cities=ArrayHelper::map(Citydescription::find()->where('`title` LIKE "%'.$this->city.'%"')->all(), 'id', 'id');
            }
            if(!empty($cities))
                $prodidscities=ArrayHelper::map(Productscities::find()->where(['IN','city_id',$cities])->all(), 'product_id', 'product_id');
        }

        if(!empty($this->country)) {
            if(Yii::$app->language!=Yii::$app->sourceLanguage) {
                $countries=ArrayHelper::map(Countriestranslate::find()->where('`country_name` LIKE "%'.$this->country.'%" AND `lang_code`="'.Yii::$app->language.'"')->all(), 'country_id', 'country_id');
                if(empty($countries))
                    $countries=ArrayHelper::map(Countries::find()->where('`country_name` LIKE "%'.$this->country.'%"')->all(), 'id', 'id');
            } else {
                $countries=ArrayHelper::map(Countries::find()->where('`country_name` LIKE "%'.$this->country.'%"')->all(), 'id', 'id');
            }
            if(!empty($countries)) {
                $prodidscountries=ArrayHelper::map(Productscountires::find()->where(['IN','country_id',$countries])->all(), 'product_id', 'product_id');
            }
        }

        if(($this->city!='' && $this->country!='') && (empty($prodidscities) || empty($prodidscountries))) {
            $query->andFilterWhere(['=', 'id', 0]);
        } elseif($this->city!='' && !empty($prodidscities) && $this->country=='') {
            $query->andFilterWhere(['IN', 'id', $prodidscities]);
        } elseif($this->country!='' && !empty($prodidscountries) && $this->city=='') {
            $query->andFilterWhere(['IN', 'id', $prodidscountries]);
        } elseif(($this->country!='' && !empty($prodidscountries)) && ($this->city!='' && !empty($prodidscities))) {
            $citcount=[];
            foreach($prodidscities as $city)
            {
                if(ArrayHelper::isIn($city, $prodidscountries))
                   $citcount[]=$city;
            }
            $query->andFilterWhere(['IN', 'id', $citcount]);
        } elseif(($this->city!='' && empty($prodidscities)) || ($this->country!='' && empty($prodidscountries))) {
            $query->andFilterWhere(['=', 'id', 0]);
        }


        $query->orderBy(new Expression('rand()'));

        return $dataProvider;

    }

}

