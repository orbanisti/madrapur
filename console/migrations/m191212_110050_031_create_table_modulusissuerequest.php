<?php

use yii\db\Migration;

class m191212_110050_031_create_table_modulusissuerequest extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusissuerequest}}', [
            'id' => $this->primaryKey(),
            'content' => $this->text(),
            'image' => $this->text(),
            'priority' => $this->text(),
            'status' => $this->text(),
            'assignedUser' => $this->integer(),
            'createdAt' => $this->bigInteger(),
            'updatedAt' => $this->bigInteger(),
            'createdBy' => $this->integer(),
            'updatedBy' => $this->integer(),
            'category' => $this->text(),
        ], $tableOptions);

        $this->createIndex('modulusIssuerequest_id_uindex', '{{%modulusissuerequest}}', 'id', true);
    }

    public function down()
    {
        $this->dropTable('{{%modulusissuerequest}}');
    }
}
