<?php

use yii\db\Migration;

class m191216_090802_063_create_table_i18n_message extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%i18n_message}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text(),
        ], $tableOptions);

        $this->addPrimaryKey('PRIMARYKEY', '{{%i18n_message}}', ['id', 'language']);
        $this->addForeignKey('fk_i18n_message_source_message', '{{%i18n_message}}', 'id', '{{%i18n_source_message}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%i18n_message}}');
    }
}
