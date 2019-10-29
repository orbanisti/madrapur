<?php

use yii\db\Schema;
use yii\db\Migration;

class m191029_110955_modulusissuerequest extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%modulusIssuerequest}}',
            [
                'id'=> $this->primaryKey(11),
                'content'=> $this->text()->null()->defaultValue(null),
                'image'=> $this->text()->null()->defaultValue(null),
                'priority'=> $this->text()->null()->defaultValue(null),
                'status'=> $this->text()->null()->defaultValue(null),
                'assignedUser'=> $this->integer(11)->null()->defaultValue(null),
                'createdAt'=> $this->bigInteger(20)->null()->defaultValue(null),
                'updatedAt'=> $this->bigInteger(20)->null()->defaultValue(null),
                'createdBy'=> $this->integer(11)->null()->defaultValue(null),
                'updatedBy'=> $this->integer(11)->null()->defaultValue(null),
                'category'=> $this->text()->null()->defaultValue(null),
            ],$tableOptions
        );
        $this->createIndex('modulusIssuerequest_id_uindex','{{%modulusIssuerequest}}',['id'],true);

    }

    public function safeDown()
    {
        $this->dropIndex('modulusIssuerequest_id_uindex', '{{%modulusIssuerequest}}');
        $this->dropTable('{{%modulusIssuerequest}}');
    }
}
