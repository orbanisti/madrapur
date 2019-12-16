<?php

use yii\db\Migration;

class m191216_090802_051_create_table_system_mad_migrate extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%system_mad_migrate}}', [
            'version' => $this->string(180)->notNull()->append('PRIMARY KEY'),
            'apply_time' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%system_mad_migrate}}');
    }
}
