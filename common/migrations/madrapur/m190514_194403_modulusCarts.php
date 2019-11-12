<?php

use yii\db\Schema;
use yii\db\Migration;

class m190514_194403_modulusCarts extends Migration {
    public $tableName = "modulusCarts";
    public $tableOptions = "";

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            $this->tableName, [
            'id' => $this->primaryKey(),
            'items'=> $this->string(50000),
            'createDate'=>$this->string(300),
        ], $this->tableOptions
        );
        $this->insert($this->tableName, [
            'id' => "1",
            'items'=>'{"items":["item1","item2","item3"],"total":200}',
            'createDate'=>date('Y-m-d'),
        ]);
    }

    public function safeDown() {
        $this->dropTable($this->tableName);
    }
}
