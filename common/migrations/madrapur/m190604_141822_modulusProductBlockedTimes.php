<?php

use yii\db\Schema;
use yii\db\Migration;

class m190604_141822_modulusProductBlockedTimes extends Migration {
    public $tableName = "modulusProductBlockedTimes";
    public $tableOptions = "";

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB';
        }

        $this->createTable(
            $this->tableName, [
            'id' => $this->primaryKey(),
            'product_id'=> $this->string(200)->notNull(),
            'date'=>$this->string(50),


        ], $this->tableOptions
        );
    }

    public function safeDown() {
        $this->dropTable($this->tableName);
    }
}
