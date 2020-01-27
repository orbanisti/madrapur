<?php

namespace backend\modules\Reservations\models;

use backend\modules\MadActiveRecord\models\MadActiveRecord;
use backend\modules\Product\models\Product;
use backend\modules\Product\models\ProductTime;
use backend\modules\Reservations\controllers\ReservationsController;
use backend\modules\Tickets\models\TicketBlock;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ReservationsImport extends MadActiveRecord {

    public function rules() {
        return [
            [['site'], 'string', 'max' => 100],
            [['fromDate'], 'date', 'format' => 'yyyy-mm-dd'],

        ];
    }


}