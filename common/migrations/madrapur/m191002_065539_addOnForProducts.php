<?php

use yii\db\Schema;
use yii\db\Migration;

class m191002_065539_addOnForProducts extends Migration {
    public $tableName = "modulusProductAddOnLink";
    public $tableOptions = "";

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            $this->tableName, [
                'id' => $this->primaryKey(),
                'addOnId' => $this->integer(11)->notNull(),
                'prodId' => $this->integer(11)->notNull(),
            ], $this->tableOptions
        );

        $this->addForeignKey(
            "fk_add_on_id",
            $this->tableName,
            "addOnId",
            "modulusProductAddOns",
            "id",
            "CASCADE",
            "CASCADE"
        );

        $this->addForeignKey(
            "fk_product_id",
            $this->tableName,
            "addOnId",
            "modulusProducts",
            "id",
            "CASCADE",
            "CASCADE"
        );
    }

    public function safeDown() {
        $this->dropForeignKey("fk_product_id", $this->tableName);
        $this->dropForeignKey("fk_add_on_id", $this->tableName);
        $this->dropTable($this->tableName);
    }
}
