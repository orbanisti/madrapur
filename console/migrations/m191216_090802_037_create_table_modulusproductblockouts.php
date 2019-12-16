<?php

use yii\db\Migration;

class m191216_090802_037_create_table_modulusproductblockouts extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusproductblockouts}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->string(200)->notNull(),
            'dates' => $this->string(8000),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulusproductblockouts}}');
    }
}
