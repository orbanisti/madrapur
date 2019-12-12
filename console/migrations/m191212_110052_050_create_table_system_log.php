<?php

use yii\db\Migration;

class m191212_110052_050_create_table_system_log extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%system_log}}', [
            'id' => $this->bigPrimaryKey(),
            'level' => $this->integer(),
            'category' => $this->string(),
            'log_time' => $this->double(),
            'prefix' => $this->text(),
            'message' => $this->text(),
        ], $tableOptions);

        $this->createIndex('idx_log_level', '{{%system_log}}', 'level');
        $this->createIndex('idx_log_category', '{{%system_log}}', 'category');
    }

    public function down()
    {
        $this->dropTable('{{%system_log}}');
    }
}
