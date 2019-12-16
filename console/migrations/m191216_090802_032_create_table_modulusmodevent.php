<?php

use yii\db\Migration;

class m191216_090802_032_create_table_modulusmodevent extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusmodevent}}', [
            'id' => $this->primaryKey(),
            'date' => $this->dateTime(),
            'place' => $this->text(),
            'status' => $this->text(),
            'user' => $this->text(),
            'title' => $this->text(),
            'startDate' => $this->date(),
            'endDate' => $this->date(),
        ], $tableOptions);

        $this->createIndex('modulusModevent_id_uindex', '{{%modulusmodevent}}', 'id', true);
    }

    public function down()
    {
        $this->dropTable('{{%modulusmodevent}}');
    }
}
