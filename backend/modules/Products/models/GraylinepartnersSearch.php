<?php

namespace backend\modules\Products\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Products\models\Graylinepartners;

/**
 * GraylinepartnersSearch represents the model behind the search form about `backend\modules\Products\models\Graylinepartners`.
 */
class GraylinepartnersSearch extends Graylinepartners
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'channel', 'status', 'imported'], 'integer'],
            [['name', 'description', 'link'], 'safe'],
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
        $query = Graylinepartners::find();

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
            'channel' => $this->channel,
            'status' => $this->status,
            'imported' => $this->imported,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
