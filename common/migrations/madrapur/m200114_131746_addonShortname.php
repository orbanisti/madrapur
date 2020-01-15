<?php

use yii\db\Schema;
use yii\db\Migration;

class m200114_131746_addonShortname extends Migration {
    public $tableName = "modulusProductAddons";
    public $columnName = "shortName";


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
