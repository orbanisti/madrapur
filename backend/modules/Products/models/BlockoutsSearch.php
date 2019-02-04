<?php

namespace backend\modules\Products

namespace app\modules\Products\models;



use Yii;

use yii\base\Model;

use yii\data\ActiveDataProvider;

use app\modules\Products\models\Blockouts;

use app\modules\Order\models\Orderedproducts;



/**

 * BlockoutsSearch represents the model behind the search form about `app\modules\Products\models\Blockouts`.

 */

class BlockoutsSearch extends Blockouts

{

    /**

     * @inheritdoc

     */

    public function rules()

    {

        return [

            [['id', 'product_id'], 'integer'],

            [['start_date', 'end_date'], 'safe'],

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

        $query = Blockouts::find();



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

            'start_date' => $this->start_date,

            'end_date' => $this->end_date,

            'product_id' => $this->product_id,

        ]);

        

        $myproducts=Products::getUserproductsids();

        $query->andFilterWhere(['IN', 'product_id', $myproducts]);



        return $dataProvider;

    }

}

