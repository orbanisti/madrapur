<?phpnamespace backend\modules\Products



namespace app\modules\Products\models;



use Yii;

use yii\base\Model;

use yii\data\ActiveDataProvider;

use app\modules\Products\models\Cities;



/**

 * CitiesSearch represents the model behind the search form about `app\modules\Products\models\Cities`.

 */

class CitiesSearch extends Cities

{

    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['id'], 'integer'],

            [['name'], 'safe'],

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



    /**

     * Creates data provider instance with search query applied

     *

     * @param array $params

     *

     * @return ActiveDataProvider

     */

    public function search($params)

    {

        $query = Cities::find();



        $dataProvider = new ActiveDataProvider([

            'query' => $query,

        ]);



        $this->load($params);



        if (!$this->validate()) {

            // uncomment the following line if you do not want to return any records when validation fails

            // $query->where('0=1');

            return $dataProvider;

        }



        $query->andFilterWhere([

            'id' => $this->id,

        ]);



        $query->andFilterWhere(['like', 'name', $this->name]);



        return $dataProvider;

    }

}

