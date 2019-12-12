<?php

use yii\db\Migration;

class m191212_110052_045_create_table_modulusworkshift extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusworkshift}}', [
            'id' => $this->primaryKey(),
            'place' => $this->text(),
            'startTime' => $this->time(),
            'endTime' => $this->time(),
            'role' => $this->text(),
        ], $tableOptions);

        $this->createIndex('modulusWorkshift_id_uindex', '{{%modulusworkshift}}', 'id', true);
    }

    public function down()
    {
        $this->dropTable('{{%modulusworkshift}}');
    }
}
