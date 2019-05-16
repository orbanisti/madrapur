<?php

use yii\db\Schema;
use yii\db\Migration;

class m190516_085829_modulusProductBlockouts extends Migration {
    public $tableName = "modulusProductBlockouts";
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
            'dates'=>$this->string(8000),
            'start_date' => $this->date(),
            'end_date' =>  $this->date(),

        ], $this->tableOptions
        );
    }

    public function safeDown() {
        $this->dropTable($this->tableName);
    }
}
