<?php

use yii\db\Schema;
use yii\db\Migration;

class m190806_123217_modulusTicketidncancel extends Migration {

    public $tableName = "modulusBookings";


    public $newColumns=['ticketId','isCancelled','paidMethod','iSellerId','iSellerName'];

    public function safeUp() {
        foreach($this->newColumns as $newColumn){

            $this->addColumn(
                $this->tableName,
                $newColumn,
                'varchar(255)'
            );
        }
    }

    public function safeDown() {

        foreach($this->newColumns as $newColumn){

            $this->dropColumn(
                $this->tableName,
                $newColumn
            );
        }

    }

}
