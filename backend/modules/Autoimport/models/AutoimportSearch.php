<?php

namespace backend\modules\AutoImport\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\AutoImport\models\Autoimport;

/**
 * AutoimportSearch represents the model behind the search form about `backend\modules\AutoImport\models\Autoimport`.
 */
class AutoimportSearch extends Autoimport
{
    public function rules()
    {

        return [
            [['id', 'active'], 'integer'],
            [['siteUrl', 'apiUrl', 'type'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Autoimport::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'siteUrl', $this->siteUrl])
            ->andFilterWhere(['like', 'apiUrl', $this->apiUrl])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
