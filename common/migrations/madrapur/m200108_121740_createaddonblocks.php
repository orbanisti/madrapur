<?php

use yii\db\Schema;
use yii\db\Migration;

class m200108_121740_createaddonblocks extends Migration {
    public $tableName = "modulusAddonBlockouts";
    public $tableOptions = "";

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB';
        }

        $this->createTable(
            $this->tableName, [
            'id' => $this->primaryKey(),
            'productId'=> $this->string(200)->notNull(),
            'addonId'=> $this->string(200)->notNull(),
            'dates'=>$this->text(),
            'startDate' => $this->date(),
            'endDate' =>  $this->date(),

        ], $this->tableOptions
        );
    }

    public function safeDown() {
        $this->dropTable($this->tableName);
    }
}
