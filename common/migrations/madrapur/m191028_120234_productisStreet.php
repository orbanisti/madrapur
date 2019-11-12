<?php

use yii\db\Schema;
use yii\db\Migration;

class m191028_120234_productisStreet extends Migration {
    public $tableName = "modulusProducts";
    public $columnName = "isStreet";

    public function safeUp() {
        $this->addColumn(
            $this->tableName,
            $this->columnName,
            $this->string(3)->defaultValue('no')
        );

    }

    public function safeDown() {
        $this->dropColumn($this->tableName, $this->columnName);
    }
}
