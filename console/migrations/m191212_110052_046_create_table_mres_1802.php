<?php

use yii\db\Migration;

class m191212_110052_046_create_table_mres_1802 extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%mres_1802}}', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(32),
            'source' => $this->string()->notNull(),
            'data' => $this->string(1000),
            'invoice_date' => $this->date()->notNull(),
            'reservation_date' => $this->date()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%mres_1802}}');
    }
}
