<?php

use yii\db\Migration;

class m191216_090802_058_create_table_widget_carousel_item extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%widget_carousel_item}}', [
            'id' => $this->primaryKey(),
            'carousel_id' => $this->integer()->notNull(),
            'base_url' => $this->string(1024),
            'path' => $this->string(1024),
            'asset_url' => $this->string(1024),
            'type' => $this->string(),
            'url' => $this->string(1024),
            'caption' => $this->string(1024),
            'status' => $this->smallInteger()->notNull()->defaultValue('0'),
            'order' => $this->integer()->defaultValue('0'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('fk_item_carousel', '{{%widget_carousel_item}}', 'carousel_id', '{{%widget_carousel}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%widget_carousel_item}}');
    }
}
