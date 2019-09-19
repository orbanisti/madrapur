<?php

use yii\db\Schema;
use yii\db\Migration;

class m190917_104310_addProductAddons extends Migration {
    public $tableName = "{{modulusProductAddOns}}";
    public $columns = [
        "foreignKeys" => [
            "prodId" => [
                "column" => "prodId",
                "refTable" => "{{modulusProducts}}",
                "refColumns" => "id",
                "onDelete" => "CASCADE",
                "onUpdate" => "CASCADE"
            ]
        ]
    ];
    public $foreignTableName = "{{modulusProducts}}";
    public $tableOptions = "";

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            $this->tableName, [
                "id" => $this->primaryKey(),
                "prodId" => $this->integer(11)->notNull(),
                "name" => $this->string(255),
                "icon" => $this->string(255)->defaultValue("fa-check"),
                "type" => "ENUM('boolean', 'integer')",
            ],
            $this->tableOptions
        );

        foreach ($this->columns["foreignKeys"] as $name => $foreignKey) {
            $this->addForeignKey(
                $name,
                $this->tableName,
                $foreignKey["column"],
                $foreignKey["refTable"],
                $foreignKey["refColumns"],
                $foreignKey["onDelete"],
                $foreignKey["onUpdate"]
            );
        }
    }

    public function safeDown() {
        foreach ($this->columns["foreignKeys"] as $name => $foreignKey) {
            $this->dropForeignKey($name ,$this->tableName);
        }

        $this->dropTable($this->tableName);
    }
}
