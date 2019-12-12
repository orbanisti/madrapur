<?php

use yii\db\Migration;

class m191212_110052_033_create_table_modulusorders extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusorders}}', [
            'id' => $this->primaryKey(),
            'status' => $this->string(),
            'transactionId' => $this->string(),
            'reservationIds' => $this->string(),
            'data' => $this->text(),
            'transactionDate' => $this->string(50),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulusorders}}');
    }
}
