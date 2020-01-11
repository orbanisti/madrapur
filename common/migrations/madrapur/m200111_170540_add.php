<?php

use yii\db\Schema;
use yii\db\Migration;

class m200111_170540_add extends Migration {
    public $tableName = "modulusproducts";
    public $columnName = "type";


    public function safeUp() {
        $this->addColumn(
            $this->tableName,
            $this->columnName,
            $this->text()
        );

    }

    public function safeDown() {
        $this->dropColumn($this->tableName, $this->columnName);

    }
}
