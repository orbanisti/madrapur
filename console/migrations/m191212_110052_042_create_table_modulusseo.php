<?php

use yii\db\Migration;

class m191212_110052_042_create_table_modulusseo extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusseo}}', [
            'id' => $this->primaryKey(),
            'postId' => $this->bigInteger(15)->notNull(),
            'postType' => $this->bigInteger(15)->notNull(),
            'source' => $this->text(),
            'mainKeyword' => $this->text(),
            'meta+name+description' => $this->text(),
            'meta+name+keywords' => $this->text(),
            'meta+name+alternate' => $this->text(),
            'meta+name+canonical' => $this->text(),
            'meta+name+author' => $this->text(),
            'meta+name+news_keywords' => $this->text(),
            'meta+property+fb+pages' => $this->text(),
            'meta+property+og+type' => $this->text(),
            'meta+property+og+url' => $this->text(),
            'meta+property+og+title' => $this->text(),
            'meta+property+og+site_name' => $this->text(),
            'meta+property+og+locale' => $this->text(),
            'meta+property+og+updated_time' => $this->text(),
            'meta+property+og+description' => $this->text(),
            'meta+property+og+image+alt' => $this->text(),
            'meta+property+og+image' => $this->text(),
            'meta+property+article+publisher' => $this->text(),
            'meta+property+m+publication_local' => $this->text(),
            'meta+property+m+publication' => $this->text(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulusseo}}');
    }
}
