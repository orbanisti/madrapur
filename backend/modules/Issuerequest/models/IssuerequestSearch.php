<?php

namespace backend\modules\Issuerequest\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Issuerequest\models\Issuerequest;

/**
 * IssuerequestSearch represents the model behind the search form about `\backend\modules\Issuerequest\models\Issuerequest`.
 */
class IssuerequestSearch extends Issuerequest
{
    public function rules()
    {
        return [
            [['id', 'assignedUser', 'createdBy', 'updatedBy'], 'integer'],
            [['content', 'image', 'priority', 'status', 'createdAt', 'updatedAt'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Issuerequest::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'assignedUser' => $this->assignedUser,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'priority', $this->priority])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
