<?php

use yii\db\Schema;
use yii\db\Migration;

class m190613_142245_notesForSellers extends Migration {
    public $tableName = "modulusBookings";
    public $tableOptions = "";
    public $columns = [
        "alterable" => [],
        "disposable" => [],
        "new" => [
            "notes" => Schema::TYPE_TEXT,
        ],
        "seedable" => [],
    ];

    public function safeUp() {
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
