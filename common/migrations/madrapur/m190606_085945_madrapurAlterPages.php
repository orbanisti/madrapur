<?php

use yii\db\Schema;
use yii\db\Migration;

class m190606_085945_madrapurAlterPages extends Migration {
    public $tableName = "page";
    public $tableOptions = "";
    public $columns = [
        "alterable" => [],
        "disposable" => [
            "view" => "varchar(255)",
        ],
        "new" => [
            "meta+name+description" => Schema::TYPE_TEXT,
            "meta+name+keywords" => Schema::TYPE_TEXT,
            "meta+name+alternate" => Schema::TYPE_TEXT,
            "meta+name+canonical" => Schema::TYPE_TEXT,
            "meta+name+author" => Schema::TYPE_TEXT,
            "meta+name+news_keywords" => Schema::TYPE_TEXT,

            "meta+property+fb+pages" => Schema::TYPE_TEXT,
            "meta+property+og+type" => Schema::TYPE_TEXT,
            "meta+property+og+url" => Schema::TYPE_TEXT,
            "meta+property+og+title" => Schema::TYPE_TEXT,
            "meta+property+og+site_name" => Schema::TYPE_TEXT,
            "meta+property+og+locale" => Schema::TYPE_TEXT,
            "meta+property+og+updated_time" => Schema::TYPE_TEXT,
            "meta+property+og+description" => Schema::TYPE_TEXT,
            "meta+property+og+image+alt" => Schema::TYPE_TEXT,
            "meta+property+og+image" => Schema::TYPE_TEXT,
            "meta+property+article+publisher" => Schema::TYPE_TEXT,

            "meta+property+m+publication_local" => Schema::TYPE_TEXT,
            "meta+property+m+publication" => Schema::TYPE_TEXT,
        ],
    ];

    public function safeUp() {
        $table = $this->getDb()->getSchema()->getTableSchema($this->tableName);

        if (isset($table->columns['view'])) {
            $this->dropColumn($this->tableName, 'view');
        }

        foreach ($this->columns['new'] as $name => $type) {
            $this->addColumn(
                $this->tableName,
                $name,
                $type
            );
        }
    }

    public function safeDown() {;
        $table = $this->getDb()->getSchema()->getTableSchema($this->tableName);

        if (isset($table->columns['view'])) {
            $this->addColumn(
                $this->tableName,
                'view',
                'varchar(255)'
            );
        }

        foreach ($this->columns['new'] as $name => $type) {
            $this->dropColumn(
                $this->tableName,
                $name
            );
        }
    }
}
