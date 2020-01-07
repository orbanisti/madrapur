<?php

use yii\db\Schema;
use yii\db\Migration;

class m200107_114341_extendpages extends Migration {
    public $tableName = "page";
    public $columnName = "isHome";


    public function safeUp() {
        $this->addColumn(
            $this->tableName,
            $this->columnName,
            $this->integer(3)
        );

    }

    public function safeDown() {
        $this->dropColumn($this->tableName, $this->columnName);

    }
}
