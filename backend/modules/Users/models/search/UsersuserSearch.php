<?php

backend\

namespace app\modules\Users\models\search;


backend\
use backend\

use yii\base\Model;
backend\
use yii\data\ActiveDataProvider;

use app\modules\Users\models\Users;

use app\modules\Users\Module as Usermodule;



/**

 * UsersSearch represents the model behind the search form about `app\modules\Users\models\Users`.

 */

class UsersuserSearch extends Users

{

    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['id', 'payment_in_advance', 'status', 'rights', 'type'], 'integer'],

            [['email', 'username', 'password', 'regdate', 'hashcode'], 'safe'],

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

        $query = Users::find();



        $dataProvider = new ActiveDataProvider([

            'query' => $query,

            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]

        ]);



        $this->load($params);



        if (!$this->validate()) {

            // uncomment the following line if you do not want to return any records when validation fails

            // $query->where('0=1');

            return $dataProvider;

        }



        $query->andFilterWhere([

            'id' => $this->id,

            'regdate' => $this->regdate,

            'status' => $this->status,

            'rights' => $this->rights,

            'type' => Usermodule::TYPE_PERSON,

            'payment_in_advance' => $this->payment_in_advance,

        ]);



        $query->andFilterWhere(['like', 'email', $this->email])

            ->andFilterWhere(['like', 'username', $this->username])

            ->andFilterWhere(['like', 'password', $this->password])

            ->andFilterWhere(['like', 'hashcode', $this->hashcode]);



        return $dataProvider;

    }

}

