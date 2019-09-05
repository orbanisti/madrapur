<?php

use yii\db\Schema;
use yii\db\Migration;

class m190904_131232_addTicketBlockStatus extends Migration {
    public $tableName = "modulus_ticket_blocks";
    public $tableOptions = "";
    public $columns = [
        "new" => [
            "isActive" => Schema::TYPE_BOOLEAN,
        ]
    ];

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        foreach ($this->columns['new'] as $name => $type) {
            $this->addColumn(
                $this->tableName,
                $name,
                $type
            );
        }
    }

    public function safeDown() {
        foreach ($this->columns['new'] as $name => $type) {
            $this->dropColumn(
                $this->tableName,
                $name
            );
        }
    }
}
