<?php

use yii\db\Schema;
use yii\db\Migration;

class m190327_150209_modulusPrTimes extends Migration {
    public $tableName = "tableName";
    public $tableOptions = "";

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB';
        }

        $this->createTable(
            $this->tableName, [
            'id' => $this->primaryKey(),
            'product_id'=> $this->string(12)->notNull(),
            'name'=>$this->string(100)->notNull(),
            'start_date' => $this->date()->notNull(),
            'end_date' =>  $this->date()->notNull(),
            'short_description' =>  $this->string(3000)->notNull(),
            'thumbnail'=>  $this->string(500)->notNull(),
            'images'=>  $this->string(1000)->notNull(),
            'category'=>$this->string(1000)->notNull(),
            'start_date'=>$this->string(50)->notNull(),
            'end_date'=>$this->string(50)->notNull(),
            'capacity'=>$this->string(50)->notNull(),
            'duration'=>$this->string(50)->notNull()
        ], $this->tableOptions
        );
    }

    public function safeDown() {
        $this->dropTable($this->tableName);
    }
}
