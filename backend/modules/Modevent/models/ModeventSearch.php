<?php

namespace backend\modules\Modevent\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Modevent\models\Modevent;

/**
 * ModeventSearch represents the model behind the search form about `backend\modules\Modevent\models\Modevent`.
 */
class ModeventSearch extends Modevent
{
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['date', 'place', 'user', 'title'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Modevent::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'place', $this->place])
            ->andFilterWhere(['like', 'user', $this->user])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
