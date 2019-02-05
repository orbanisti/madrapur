<?phpbackend\backend\backend\

namespace app\modules\Users\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Users\models\Users;
use app\modules\Users\Module as Usermodule;

class UserspartnerSearch extends Users
{
    public function rules()
    {
        return [
            [['id', 'payment_in_advance', 'status', 'rights', 'type', 'commission_type'], 'integer'],
            [['email', 'username', 'password', 'regdate', 'hashcode'], 'safe'],
            [['commission'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'regdate' => $this->regdate,
            'status' => $this->status,
            'rights' => $this->rights,
            'type' => Usermodule::TYPE_PARTNER,
            'payment_in_advance' => $this->payment_in_advance,
            'commission' => $this->commission,
            'commission_type' => $this->commission_type,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'hashcode', $this->hashcode]);

        $query->andFilterWhere(['<>', 'id', 195]);

        $query->andFilterWhere(['<>', 'id', 205]);
        $query->andFilterWhere(['<>', 'id', 214]);
	$query->andFilterWhere(['<>', 'id', 226]);

        return $dataProvider;

    }


}


