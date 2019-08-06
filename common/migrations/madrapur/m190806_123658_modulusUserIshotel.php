<?php

use yii\db\Schema;
use yii\db\Migration;

class m190806_123658_modulusUserIshotel extends Migration {
    public $tableName = '{{%user}}';
    public $columnName1 = "isHotel";

    public function safeUp() {
        $this->addColumn(
            $this->tableName,
            $this->columnName1,
            'varchar(3)'
        );


    }

    public function safeDown() {
        $this->dropColumn($this->tableName, $this->columnName1);

    }
}
