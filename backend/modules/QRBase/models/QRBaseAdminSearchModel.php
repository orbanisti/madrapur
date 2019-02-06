<?php
namespace backend\modules\QRBase\models;

use backend\modules\QRBase\models\QRBase;
use yii\data\ActiveDataProvider;

class QRBaseAdminSearchModel extends Products {
    public $id;
    public $uuid;
    public $source;
    public $data;
    public $invoice_date;
    public $reservation_date;

    public function rules() {
        return [
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['sku'], 'string', 'max' => 255],
            [['claimed_on'], 'datetime', 'format' => 'yyyy-MM-dd HH:ii:ss'],
            [['hash'], 'string', 'max' => 150],
            [['views'], 'integer'],
            [['until'], 'date', 'format' => 'yyyy-MM-dd'],
        ];
    }

    public function search($params) {
        $query = QRBase::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        $this->load($params);

        return $dataProvider;
    }
}

