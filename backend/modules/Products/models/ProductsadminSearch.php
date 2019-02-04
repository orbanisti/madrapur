<?phpnamespace backend\modules\Products

namespace app\modules\Products\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Products\models\Products;
use app\modules\Products\models\Productscities;
use app\modules\Products\models\Productscountires;
use yii\helpers\ArrayHelper;
use app\modules\Products\models\Graylinepartners;

class ProductsadminSearch extends Products
{
    public $minprice;
    public $maxprice;
    public $catlist;
    public $search;
    public $users;
    public $user;
    public $city_id;
    public $country_id;
    public $contract;

    public function rules()
    {
        return [

            [['id', 'channel_id', 'city_id', 'country_id', 'modified','status', 'source', 'category_id', 'time', 'max_participator', 'highlight', 'highlight_time', 'moderator_rating', 'classification', 'user_id', 'contract'], 'integer'],
            [['search', 'name', 'intro', 'description', 'country', 'city', 'address', 'start_date', 'end_date', 'services', 'link'], 'safe'],
            [['price', 'minprice', 'maxprice'], 'number'],
            ['catlist', 'each', 'rule' => ['integer']],
            ['users', 'each', 'rule' => ['integer']],
            [['user'], 'safe'],
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

        $query->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        $dataProvider->sort->attributes['user'] = [
            'asc' => ['users.username' => SORT_ASC],
            'desc' => ['users.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //Yii::$app->extra->e($this);

        $query->andFilterWhere([
            'products.id' => $this->id,
            'products.status' => $this->status,
            'products.source' => $this->source,
            'products.modified' => $this->modified,
            'products.category_id' => $this->category_id,
            //'products.price' => $this->price,
            'products.start_date' => $this->start_date,
            'products.end_date' => $this->end_date,
            'products.time' => $this->time,
            'products.max_participator' => $this->max_participator,
            'products.highlight' => $this->highlight,
            'products.highlight_time' => $this->highlight_time,
            'products.moderator_rating' => $this->moderator_rating,
            'products.classification' => $this->classification,
            'products.user_id' => $this->user_id,
            'users.id' => $this->user,
            'users.contract' => $this->contract,
            'products.channel_id' => $this->channel_id,
        ]);



        $query->andFilterWhere(['like', 'products.name', $this->name])
            ->andFilterWhere(['like', 'products.intro', $this->intro])
            ->andFilterWhere(['like', 'products.description', $this->description])
            ->andFilterWhere(['like', 'products.country', $this->country])
            ->andFilterWhere(['like', 'products.city', $this->city])
            ->andFilterWhere(['like', 'products.address', $this->address])
            ->andFilterWhere(['like', 'products.services', $this->services])
            ->andFilterWhere(['like', 'products.link', $this->link])
            //->andFilterWhere(['>=', 'products.price', $this->minprice])
            //->andFilterWhere(['<=', 'products.price', $this->maxprice])
            ->andFilterWhere(['in', 'products.category_id', $this->catlist]);

        if(!empty($this->city_id)) {
            $cityprodids=ArrayHelper::map(Productscities::find()->where(['city_id'=>$this->city_id])->all(),'product_id','product_id');
            $query->andFilterWhere(['in', 'products.id', $cityprodids]);
        }

        if(!empty($this->country_id)) {
            $countryprodids=ArrayHelper::map(Productscountires::find()->where(['country_id'=>$this->country_id])->all(),'product_id','product_id');
            $query->andFilterWhere(['in', 'products.id', $countryprodids]);
        }

        $gapartners=ArrayHelper::map(Graylinepartners::find()->where(['status'=>1])->all(), 'channel', 'channel');

        $query->andFilterWhere(['OR',['<>', 'source',1],['IN', 'channel_id',$gapartners]]);


        return $dataProvider;

    }

}

