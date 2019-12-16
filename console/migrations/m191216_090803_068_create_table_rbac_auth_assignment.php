<?php

use yii\db\Migration;

class m191216_090803_068_create_table_rbac_auth_assignment extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%rbac_auth_assignment}}', [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
        ], $tableOptions);

        $this->addPrimaryKey('PRIMARYKEY', '{{%rbac_auth_assignment}}', ['item_name', 'user_id']);
        $this->addForeignKey('rbac_auth_assignment_ibfk_1', '{{%rbac_auth_assignment}}', 'item_name', '{{%rbac_auth_item}}', 'name', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%rbac_auth_assignment}}');
    }
}
