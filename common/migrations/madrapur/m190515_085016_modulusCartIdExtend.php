<?php

use yii\db\Schema;
use yii\db\Migration;

class m190515_085016_modulusCartIdExtend extends Migration {
    public $tableName = "modulusCarts";
    public $tableOptions = "";


    public $fields = [
        'id'
    ];

    public function safeUp() {
        foreach ($this->fields as $field) {
            $this->alterColumn(
                $this->tableName,
                $field,
                $this->string(100)
            );
        }
    }


    public function safeDown() {
        foreach ($this->fields as $field) {
            $this->alterColumn(
                $this->tableName,
                $field,
                $this->integer(20)
            );
        }

    }
}
