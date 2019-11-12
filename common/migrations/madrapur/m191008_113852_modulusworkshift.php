<?php

use yii\db\Schema;
use yii\db\Migration;

class m191008_113852_modulusworkshift extends Migration
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
            'modulusWorkshift',
            [
                'id'=> $this->primaryKey(11),
                'place'=> $this->text()->null()->defaultValue(null),
                'startTime'=> $this->time()->null()->defaultValue(null),
                'endTime'=> $this->time()->null()->defaultValue(null),
                'role'=> $this->text()->null()->defaultValue(null),
            ],$tableOptions
        );
        $this->createIndex('modulusWorkshift_id_uindex','{{%modulusWorkshift}}',['id'],true);

    }

    public function safeDown()
    {
        $this->dropIndex('modulusWorkshift_id_uindex', '{{%modulusWorkshift}}');
        $this->dropTable('modulusWorkshift');
    }
}
