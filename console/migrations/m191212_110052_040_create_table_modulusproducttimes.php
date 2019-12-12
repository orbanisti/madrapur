<?php

use yii\db\Migration;

class m191212_110052_040_create_table_modulusproducttimes extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusproducttimes}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->string(20)->notNull(),
            'name' => $this->string(5000),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulusproducttimes}}');
    }
}
