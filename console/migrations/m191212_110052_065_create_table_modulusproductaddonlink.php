<?php

use yii\db\Migration;

class m191212_110052_065_create_table_modulusproductaddonlink extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusproductaddonlink}}', [
            'id' => $this->primaryKey(),
            'addOnId' => $this->integer()->notNull(),
            'prodId' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_add_on_id', '{{%modulusproductaddonlink}}', 'addOnId', '{{%modulusproductaddons}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_product_id', '{{%modulusproductaddonlink}}', 'addOnId', '{{%modulusproducts}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%modulusproductaddonlink}}');
    }
}
