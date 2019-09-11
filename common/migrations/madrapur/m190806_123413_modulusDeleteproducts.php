<?php

use yii\db\Schema;
use yii\db\Migration;

class m190806_123413_modulusDeleteproducts extends Migration {
    public $tableName = "modulusProducts";
    public $columnName1 = "isDeleted";

    public function safeUp() {
        $this->addColumn(
            $this->tableName,
            $this->columnName1,
            $this->char(4)->defaultValue('no')
        );


    }

    public function safeDown() {
        $this->dropColumn($this->tableName, $this->columnName1);

    }
}
