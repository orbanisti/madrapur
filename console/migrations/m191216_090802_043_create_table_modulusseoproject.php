<?php

use yii\db\Migration;

class m191216_090802_043_create_table_modulusseoproject extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusseoproject}}', [
            'id' => $this->primaryKey(),
            'domain' => $this->string(50)->notNull(),
            'title' => $this->text(),
        ], $tableOptions);

        $this->createIndex('domain', '{{%modulusseoproject}}', 'domain', true);
    }

    public function down()
    {
        $this->dropTable('{{%modulusseoproject}}');
    }
}
