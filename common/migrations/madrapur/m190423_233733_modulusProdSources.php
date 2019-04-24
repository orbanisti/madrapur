<?php

use yii\db\Schema;
use yii\db\Migration;

class m190423_233733_modulusProdSources extends Migration {
    public $tableName = "modulusProdSources";
    public $tableOptions = "";

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            $this->tableName, [
            'id' => $this->primaryKey(),
            'product_id'=> $this->string(20)->notNull(),
            'name'=>$this->string(155),
            'url'=>$this->string(155),
            'prodIds' => $this->bigInteger(15),
            'color'=>$this->string(30),


        ], $this->tableOptions
        );
    }

    public function safeDown() {
        $this->dropTable($this->tableName);
    }
}
