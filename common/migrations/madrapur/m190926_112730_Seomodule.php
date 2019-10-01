<?php

use yii\db\Schema;
use yii\db\Migration;

class m190926_112730_Seomodule extends Migration {
    public $tableName = "modulusseo";
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
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            $this->tableName, [
                'id' => $this->primaryKey(),
                'postId' => $this->bigInteger(15)->notNull(),
                'postType' => $this->bigInteger(15)->notNull(),
                'source' => $this->text(),
                'mainKeyword'=>$this->text()
            ], $this->tableOptions
        );
        foreach ($this->columns['new'] as $name => $type) {
            $this->addColumn(
                $this->tableName,
                $name,
                $type
            );
        }



    }

    public function safeDown() {
        $this->dropTable($this->tableName);
    }
}
