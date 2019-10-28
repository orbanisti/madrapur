<?php

use yii\db\Schema;
use yii\db\Migration;

class m191008_113811_modulusmodevent extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable(
            'modulusModevent',
            [
                'id'=> $this->primaryKey(11),
                'date'=> $this->datetime()->null()->defaultValue(null),
                'place'=> $this->text()->null()->defaultValue(null),
                'status'=> $this->text()->null()->defaultValue(null),
                'user'=> $this->text()->null()->defaultValue(null),
                'title'=> $this->text()->null()->defaultValue(null),
                'startDate'=> $this->date()->null()->defaultValue(null),
                'endDate'=> $this->date()->null()->defaultValue(null),
            ],$tableOptions
        );
        $this->createIndex('modulusModevent_id_uindex','{{%modulusmodevent}}',['id'],true);

    }

    public function safeDown()
    {
        $this->dropIndex('modulusModevent_id_uindex', '{{%modulusmodevent}}');
        $this->dropTable('modulusmodevent');
    }
}
