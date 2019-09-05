<?php

use yii\db\Schema;
use yii\db\Migration;

class m190806_123217_modulusTicketidncancel extends Migration {

    public $tableName = "modulusBookings";
    public $columnName1 = "ticketId";
    public $columnName2 = "isCancelled";
    public $columnName3 = "isCancelled";

    public $newColumns=['ticketId','isCancelled','paid_method','iSellerId','iSellerName'];



    public function safeUp() {
        foreach($this->newColumns as $newColumn){

            $this->addColumn(
                $this->tableName,
                $newColumn,
                'varchar(50)'
            );
        }
    }

    public function safeDown() {

        foreach($this->newColumns as $newColumn){

            $this->dropColumn(
                $this->tableName,
                $newColumn,
                'varchar(50)'
            );
        }

    }

}
