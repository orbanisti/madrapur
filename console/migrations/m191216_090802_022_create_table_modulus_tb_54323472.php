<?php

use yii\db\Migration;

class m191216_090802_022_create_table_modulus_tb_54323472 extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulus_tb_54323472}}', [
            'ticketId' => $this->string(),
            'sellerId' => $this->integer(),
            'timestamp' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'reservationId' => $this->string(),
            'status' => $this->string()->notNull()->defaultValue('open'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulus_tb_54323472}}');
    }
}
