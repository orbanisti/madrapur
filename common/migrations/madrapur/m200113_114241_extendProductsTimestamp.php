<?php

use yii\db\Schema;
use yii\db\Migration;

class m200113_114241_extendProductsTimestamp extends Migration {
    public $tableName = "modulusProducts";
    public $columnName = "createdAt";
    public $columnName2 = "updatedAt";


    public function safeUp() {
        $this->addColumn(
            $this->tableName,
            $this->columnName,
            $this->bigInteger(20)
        );
        $this->addColumn(
            $this->tableName,
            $this->columnName2,
            $this->bigInteger(20)
        );

    }

    public function safeDown() {
        $this->dropColumn($this->tableName, $this->columnName);

    }
}
