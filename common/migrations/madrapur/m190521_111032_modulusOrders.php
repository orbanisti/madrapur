<?php

use yii\db\Schema;
use yii\db\Migration;

class m190521_111032_modulusOrders extends Migration {
    public $tableName = "modulusOrders";
    public $tableOptions = "";

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            $this->tableName, [
                'id' => $this->primaryKey(),
                'status' => $this->string(255),
                'transactionId' => $this->string(255),
                'reservationIds' => $this->string(255),
                'data' => $this->string(50000),
                'transactionDate' => $this->string(50),
            ], $this->tableOptions
        );
    }

    public function safeDown() {
        $this->dropTable($this->tableName);
    }
}
