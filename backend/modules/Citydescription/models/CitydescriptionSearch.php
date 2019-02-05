<?php

namespace backend\modules\Citydescription\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Citydescription\models\Citydescription;
use backend\modules\Citydescription\models\CitydescriptionTranslate;
use yii\helpers\ArrayHelper;

class CitydescriptionSearch extends Citydescription
{
    public $citylist;
    public $search;

    public function rules()
    {
        return [
            [['id', 'country_id'], 'integer'],
            [['search', 'title', 'content', 'link'], 'safe'],
            ['citylist', 'each', 'rule' => ['integer']],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Citydescription::find();

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

        if(Yii::$app->language!=Yii::$app->sourceLanguage)
        {
            $citydesc=CitydescriptionTranslate::find()->where(['and', ['lang_code'=>Yii::$app->language],['or',['like', 'title', $this->search],['like', 'content', $this->search]]])->select('citydescription_id')->column();

            if(!empty($citydesc) || !empty($this->citylist)){
                $query->andFilterWhere(['IN', 'id', $citydesc])
                    ->andFilterWhere(['IN', 'id', $this->citylist]);
            } else {
                $query->andFilterWhere(['id'=>0]);
            }
        } else {
            $query->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'content', $this->content])
                ->andFilterWhere(['like', 'link', $this->link]);
                //->andFilterWhere(['in', 'city_id', $this->citylist]);
            $query->andFilterWhere(['or', ['in', 'city_id', $this->citylist],['or',['like', 'title', $this->search],['like', 'content', $this->search]]]);
        }

        $query->andFilterWhere(['=', 'country_id', $this->country_id]);

        //Yii::$app->extra->e($query);

        return $dataProvider;
    }
}