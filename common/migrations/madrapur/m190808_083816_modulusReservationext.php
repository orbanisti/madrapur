<?php

use yii\db\Schema;
use yii\db\Migration;

class m190808_083816_modulusReservationext extends Migration {
    public $tableName = "modulusBookings";
    public $columnName1 = "status";

    public function safeUp() {
        $this->addColumn(
            $this->tableName,
            $this->columnName1,
            'varchar(20)'
        );

    }

    public function safeDown() {
        $this->dropColumn($this->tableName, $this->columnName1);

    }


}
