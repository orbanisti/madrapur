<?php

use yii\db\Migration;

class m191216_090803_069_create_foreign_keys extends Migration
{
    public function up()
    {
        $this->addForeignKey('fk_article_category_section', '{{%article_category}}', 'parent_id', '{{%article_category}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m191216_090803_069_create_foreign_keys cannot be reverted.\n";
        return false;
    }
}