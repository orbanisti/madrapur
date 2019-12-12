<?php

use yii\db\Migration;

class m191212_110052_064_create_table_modulus_ticket_blocks extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulus_ticket_blocks}}', [
            'id' => $this->primaryKey(),
            'startId' => $this->string(8)->notNull(),
            'assignedBy' => $this->integer()->notNull(),
            'assignedTo' => $this->integer(),
            'frozen' => $this->tinyInteger(1)->notNull()->defaultValue('0'),
            'timestamp' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->string(8)->notNull(),
            'isActive' => $this->tinyInteger(1),
        ], $tableOptions);

        $this->addForeignKey('fk_user_assigned_by', '{{%modulus_ticket_blocks}}', 'assignedBy', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_assigned_to', '{{%modulus_ticket_blocks}}', 'assignedTo', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%modulus_ticket_blocks}}');
    }
}
