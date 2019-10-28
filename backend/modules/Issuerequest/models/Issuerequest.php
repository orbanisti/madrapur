<?php

namespace backend\modules\Issuerequest\models;

use Yii;
use \backend\modules\Issuerequest\models\base\Issuerequest as BaseIssuerequest;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "modulusissuerequest".
 */
class Issuerequest extends BaseIssuerequest
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
