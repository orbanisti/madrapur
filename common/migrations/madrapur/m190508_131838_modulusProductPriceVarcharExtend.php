<?php

use yii\db\Schema;
use yii\db\Migration;

class m190508_131838_modulusProductPriceVarcharExtend extends Migration {
    public $tableName = "modulusProductPrice";
    public $fields = [
        'description',
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
