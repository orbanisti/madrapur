<?php

use yii\db\Schema;
use yii\db\Migration;

class m200114_115334_bookingsExtend extends Migration {
    public $tableName = "modulusBookings";
    public $columnName = "customerName";


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
