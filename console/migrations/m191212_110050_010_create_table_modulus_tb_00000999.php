<?php

use yii\db\Migration;

class m191212_110050_010_create_table_modulus_tb_00000999 extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulus_tb_00000999}}', [
            'ticketId' => $this->string(),
            'sellerId' => $this->integer(),
            'timestamp' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'reservationId' => $this->string(),
            'status' => $this->string()->notNull()->defaultValue('open'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulus_tb_00000999}}');
    }
}
