<?php

use yii\db\Migration;

class m191216_090803_067_create_table_rbac_auth_item_child extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%rbac_auth_item_child}}', [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('PRIMARYKEY', '{{%rbac_auth_item_child}}', ['parent', 'child']);
        $this->createIndex('child', '{{%rbac_auth_item_child}}', 'child');
        $this->addForeignKey('rbac_auth_item_child_ibfk_1', '{{%rbac_auth_item_child}}', 'parent', '{{%rbac_auth_item}}', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('rbac_auth_item_child_ibfk_2', '{{%rbac_auth_item_child}}', 'child', '{{%rbac_auth_item}}', 'name', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%rbac_auth_item_child}}');
    }
}
