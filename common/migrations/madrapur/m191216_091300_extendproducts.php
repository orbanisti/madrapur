<?php

use yii\db\Schema;
use yii\db\Migration;

class m191216_091300_extendproducts extends Migration {
    public $tableName = "modulusProducts";
    public $columnName = "shortName";
    public $columnName2 = "cCode";

    public function safeUp() {
        $this->addColumn(
            $this->tableName,
            $this->columnName,
            $this->text()
        );
        $this->addColumn(
            $this->tableName,
            $this->columnName2,
            $this->text()
        );

    }

    public function safeDown() {
        $this->dropColumn($this->tableName, $this->columnName);
        $this->dropColumn($this->tableName, $this->columnName2);
    }

}
