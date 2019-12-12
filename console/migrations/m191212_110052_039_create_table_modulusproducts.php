<?php

use yii\db\Migration;

class m191212_110052_039_create_table_modulusproducts extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusproducts}}', [
            'id' => $this->primaryKey(),
            'currency' => $this->string(12)->notNull(),
            'status' => $this->string(12)->notNull(),
            'title' => $this->string(500)->notNull(),
            'description' => $this->string(5000)->notNull(),
            'short_description' => $this->string(3000)->notNull(),
            'thumbnail' => $this->string(500)->notNull(),
            'images' => $this->string(1000)->notNull(),
            'category' => $this->string(1000)->notNull(),
            'start_date' => $this->string(50)->notNull(),
            'end_date' => $this->string(50)->notNull(),
            'capacity' => $this->string(50)->notNull(),
            'duration' => $this->string(50)->notNull(),
            'slug' => $this->string(),
            'meta:name:description' => $this->text(),
            'meta:name:keywords' => $this->text(),
            'meta:name:alternate' => $this->text(),
            'meta:name:canonical' => $this->text(),
            'meta:name:author' => $this->text(),
            'meta:name:news_keywords' => $this->text(),
            'meta:property:fb:pages' => $this->text(),
            'meta:property:og:type' => $this->text(),
            'meta:property:og:url' => $this->text(),
            'meta:property:og:title' => $this->text(),
            'meta:property:og:site_name' => $this->text(),
            'meta:property:og:locale' => $this->text(),
            'meta:property:og:updated_time' => $this->text(),
            'meta:property:og:description' => $this->text(),
            'meta:property:og:image:alt' => $this->text(),
            'meta:property:og:image' => $this->text(),
            'meta:property:article:publisher' => $this->text(),
            'meta:property:m:publication_local' => $this->text(),
            'meta:property:m:publication' => $this->text(),
            'isDeleted' => $this->char(4)->defaultValue('no'),
            'isStreet' => $this->string(3)->defaultValue('no'),
            'thumbnailBase' => $this->text(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulusproducts}}');
    }
}
