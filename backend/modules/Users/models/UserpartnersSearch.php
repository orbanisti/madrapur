<?phpbackend\backend\

namespace app\modules\Users\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Users\models\Userpartners;

class UserpartnersSearch extends Userpartners
{

    public function rules()
    {
        return [
            [['id', 'user_id', 'partner_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Userpartners::find();
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
            'user_id' => $this->user_id,
            'partner_id' => $this->partner_id,
        ]);

        return $dataProvider;

    }

}

