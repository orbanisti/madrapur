<?php

use yii\db\Migration;

class m191216_090802_035_create_table_modulusproductaddons extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusproductaddons}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'icon' => $this->string()->notNull()->defaultValue('fa fa-check'),
            'type' => $this->string(),
            'price' => $this->bigInteger(15)->notNull()->defaultValue('0'),
            'hufPrice' => $this->bigInteger(13),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulusproductaddons}}');
    }
}
