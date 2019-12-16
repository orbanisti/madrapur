<?php

use yii\db\Migration;

class m191216_090801_007_create_table_modmailtemplate extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modmailtemplate}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'body' => $this->text(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modmailtemplate}}');
    }
}
