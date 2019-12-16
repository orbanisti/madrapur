<?php

use yii\db\Migration;

class m191216_090802_057_create_table_widget_carousel extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%widget_carousel}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull(),
            'status' => $this->smallInteger()->defaultValue('0'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%widget_carousel}}');
    }
}
