<?php

use yii\db\Schema;
use yii\db\Migration;

class m190508_133611_TimesPriceExtend extends Migration {
    public $tableName = "modulusProductTimes";
    public $fields = [

        'name'
    ];

    public function safeUp() {
        foreach ($this->fields as $field) {
            $this->alterColumn(
                $this->tableName,
                $field,
                $this->string(5000)
            );
        }
    }

    public function safeDown() {
        foreach ($this->fields as $field) {
            $this->alterColumn(
                $this->tableName,
                $field,
                $this->string(255)
            );
        }
    }
}
