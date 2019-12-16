<?php

use yii\db\Migration;

class m191216_090801_005_create_table_mad_qrbase extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%mad_qrbase}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'sku' => $this->string(),
            'claimed_on' => $this->date(),
            'hash' => $this->string(150),
            'views' => $this->integer(),
            'until' => $this->date(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%mad_qrbase}}');
    }
}
