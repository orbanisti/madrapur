<?php

use yii\db\Schema;
use yii\db\Migration;

class m190426_083158_addSlugToProduct extends Migration {
    public $tableName = "modulusproducts";
    public $columnName = "slug";

    public function safeUp() {
        $this->addColumn(
            $this->tableName,
            'slug',
            'varchar(255)'
        );

        $this->update(
            $this->tableName,
            [
                'slug' => 'testSlug'
            ]
        );
    }

    public function safeDown() {
        $this->dropColumn($this->tableName, $this->columnName);
    }
}
