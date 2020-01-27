<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m190525_002546_streetroles extends Migration {


        public function safeUp() {
            $auth = Yii::$app->authManager;
            $createReservation = $auth->createPermission('createReservation');
            $createReservation->description = 'Create a Reservation';
            $auth->add($createReservation);

            $streetSeller = $auth->createRole('streetSeller');
            $auth->add($streetSeller);
            $auth->addChild($streetSeller, $createReservation);




        }

        public function safeDown() {
            $auth = Yii::$app->authManager;



        }
    }
