<?php

use yii\db\Migration;

class m191216_090802_034_create_table_modulusprodsources extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusprodsources}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->string(20)->notNull(),
            'name' => $this->string(155),
            'url' => $this->string(155),
            'prodIds' => $this->bigInteger(15),
            'color' => $this->string(30),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulusprodsources}}');
    }
}
