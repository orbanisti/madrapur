<?php

use yii\db\Migration;

class m191216_090801_003_create_table_i18n_source_message extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%i18n_source_message}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(32),
            'message' => $this->text(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%i18n_source_message}}');
    }
}
