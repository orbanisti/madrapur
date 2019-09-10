<?php

use yii\db\Schema;
use yii\db\Migration;

class m190806_123217_modulusTicketidncancel extends Migration {

    public $tableName = "modulusBookings";
    public $columnName1 = "ticketId";
    public $columnName2 = "isCancelled";

    public function safeUp() {
        $this->addColumn(
            $this->tableName,
            $this->columnName1,
            'varchar(255)'
        );
        $this->addColumn(
            $this->tableName,
            $this->columnName2,
            'varchar(3)'
        );


    }

    public function safeDown() {
        $this->dropColumn($this->tableName, $this->columnName1);
        $this->dropColumn($this->tableName, $this->columnName2);
    }
}
