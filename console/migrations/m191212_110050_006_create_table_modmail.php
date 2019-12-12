<?php

use yii\db\Migration;

class m191212_110050_006_create_table_modmail extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modmail}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'from' => $this->string(),
            'to' => $this->string(),
            'subject' => $this->string(),
            'body' => $this->text(),
            'date' => $this->date(),
            'status' => $this->string(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modmail}}');
    }
}
