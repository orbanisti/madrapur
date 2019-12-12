<?php

use yii\db\Migration;

class m191212_110052_038_create_table_modulusproductprice extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusproductprice}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->string(20)->notNull(),
            'description' => $this->string(5000),
            'discount' => $this->string(155),
            'price' => $this->bigInteger(15),
            'name' => $this->string(5000),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
            'hufPrice' => $this->bigInteger(13),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulusproductprice}}');
    }
}
