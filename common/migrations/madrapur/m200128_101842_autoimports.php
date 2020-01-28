<?php

use yii\db\Schema;
use yii\db\Migration;

class m200128_101842_autoimports extends Migration {
    public $tableName = "modulusAutoimports";
    public $tableOptions = "";

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            $this->tableName, [
                'id' => $this->primaryKey(),
                'siteUrl' => $this->text(),
                'apiUrl' => $this->text(),
                'type' => $this->text(),
                'active' => $this->integer(3)->defaultValue(0),
            ], $this->tableOptions
        );
    }

    public function safeDown() {
        $this->dropTable($this->tableName);
    }
}
