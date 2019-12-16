<?php

use yii\db\Migration;

class m191216_090802_044_create_table_modulusseourl extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusseourl}}', [
            'id' => $this->primaryKey(),
            'projectId' => $this->integer(10),
            'url' => $this->text(),
            'data' => $this->text(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulusseourl}}');
    }
}
