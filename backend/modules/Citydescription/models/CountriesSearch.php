<?php

namespace app\modules\Citydescription\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Citydescription\models\Countries;

/**
 * CountriesSearch represents the model behind the search form about `app\modules\Citydescription\models\Countries`.
 */
class CountriesSearch extends Countries
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'population'], 'integer'],
            [['country_code', 'country_name', 'currency_code', 'fips_code', 'capital', 'iso_name', 'content', 'link'], 'safe'],
            [['area_size'], 'number'],
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
        $query = Countries::find();

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
            'population' => $this->population,
            'area_size' => $this->area_size,
        ]);

        $query->andFilterWhere(['like', 'country_code', $this->country_code])
            ->andFilterWhere(['like', 'country_name', $this->country_name])
            ->andFilterWhere(['like', 'currency_code', $this->currency_code])
            ->andFilterWhere(['like', 'fips_code', $this->fips_code])
            ->andFilterWhere(['like', 'capital', $this->capital])
            ->andFilterWhere(['like', 'iso_name', $this->iso_name])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'link', $this->link]);
        
        $query->andFilterWhere(['<>', 'id', 255]); //új városokhoz létrehozott ország ne legyen listázva

        return $dataProvider;
    }
}
