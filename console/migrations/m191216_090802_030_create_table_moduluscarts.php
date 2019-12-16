<?php

use yii\db\Migration;

class m191216_090802_030_create_table_moduluscarts extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%moduluscarts}}', [
            'id' => $this->string(100)->notNull()->append('PRIMARY KEY'),
            'items' => $this->text(),
            'createDate' => $this->string(300),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%moduluscarts}}');
    }
}
