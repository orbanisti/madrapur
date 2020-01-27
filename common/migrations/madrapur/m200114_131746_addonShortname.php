<?php

use yii\db\Schema;
use yii\db\Migration;

class m200114_131746_addonShortname extends Migration {
    public function safeUp() {
        $auth = Yii::$app->authManager;
        $createReservation = $auth->createPermission('createReservation');
        $createReservation->description = 'Create a Reservation';
        $auth->add($createReservation);

        $streetSeller = $auth->createRole('onlinePartner');
        $auth->add($streetSeller);
        $auth->addChild($streetSeller, $createReservation);




    }

    public function safeDown() {
        $auth = Yii::$app->authManager;



    }
}
