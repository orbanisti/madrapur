<?php

namespace backend\modules\Products



namespace app\modules\Products\models;





use Yii;


use yii\base\Model;


use yii\data\ActiveDataProvider;


use app\modules\Products\models\Productsopinion;





/**


 * ProductsopinionSearch represents the model behind the search form about `app\modules\Products\models\Productsopinion`.


 */


class ProductsopinionSearch extends Productsopinion


{


    public $productlist=[];


    /**


     * @inheritdoc


     */


    public function rules()


    {


        return [


            [['id', 'product_id', 'user_id', 'rating'], 'integer'],


            ['productlist', 'each', 'rule' => ['integer']],


            [['comment'], 'safe'],


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


        $query = Productsopinion::find();





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


            'product_id' => $this->product_id,


            'user_id' => $this->user_id,


            'rating' => $this->rating,


        ]);


        


        $query->andFilterWhere(['in', 'product_id', $this->productlist]);





        $query->andFilterWhere(['like', 'comment', $this->comment]);





        return $dataProvider;


    }


}


