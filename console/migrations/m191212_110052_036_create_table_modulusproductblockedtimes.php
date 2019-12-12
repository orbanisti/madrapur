<?php

use yii\db\Migration;

class m191212_110052_036_create_table_modulusproductblockedtimes extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusproductblockedtimes}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->string(200)->notNull(),
            'date' => $this->string(50),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulusproductblockedtimes}}');
    }
}
