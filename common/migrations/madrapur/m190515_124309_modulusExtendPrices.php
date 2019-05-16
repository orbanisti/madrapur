<?php

use yii\db\Schema;
use yii\db\Migration;

class m190515_124309_modulusExtendPrices extends Migration {
    public $tableName = "modulusProductPrice";
    public $tableOptions = "";



    public function safeUp() {
            $this->addColumn(
                $this->tableName,
                'start_date',
                $this->date()
            );
            $this->addColumn(
                $this->tableName,
                'end_date',
                $this->date()
            );

    }


    public function safeDown() {
        $this->dropColumn(
            $this->tableName,
            'start_date',
            $this->date()
        );
        $this->dropColumn(
            $this->tableName,
            'end_date',
            $this->date()
        );

    }
}
