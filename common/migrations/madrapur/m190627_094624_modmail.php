<?php

use yii\db\Schema;
use yii\db\Migration;

class m190627_094624_modmail extends Migration {
    public $tableName = "modmail";
    public $tableOptions = "";


    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            $this->tableName, [
            'id' => $this->primaryKey(),
            'type' => $this->string(255),
            'from' => $this->string(255),
            'to'=>$this->string(255),
            'subject'=>$this->string(255),
            'body'=>$this->string(100000),
            'date'=>$this->date(),
            'status'=>$this->string(255)

        ], $this->tableOptions
        );

    }

    public function safeDown() {
        $this->dropTable($this->tableName);
    }
}
