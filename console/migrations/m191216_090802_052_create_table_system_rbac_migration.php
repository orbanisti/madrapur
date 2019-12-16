<?php

use yii\db\Migration;

class m191216_090802_052_create_table_system_rbac_migration extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%system_rbac_migration}}', [
            'version' => $this->string(180)->notNull()->append('PRIMARY KEY'),
            'apply_time' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%system_rbac_migration}}');
    }
}
