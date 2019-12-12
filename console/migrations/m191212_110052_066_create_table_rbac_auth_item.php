<?php

use yii\db\Migration;

class m191212_110052_066_create_table_rbac_auth_item extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%rbac_auth_item}}', [
            'name' => $this->string(64)->notNull()->append('PRIMARY KEY'),
            'type' => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('rule_name', '{{%rbac_auth_item}}', 'rule_name');
        $this->createIndex('idx-auth_item-type', '{{%rbac_auth_item}}', 'type');
        $this->addForeignKey('rbac_auth_item_ibfk_1', '{{%rbac_auth_item}}', 'rule_name', '{{%rbac_auth_rule}}', 'name', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%rbac_auth_item}}');
    }
}
