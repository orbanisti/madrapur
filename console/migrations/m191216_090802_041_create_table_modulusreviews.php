<?php

use yii\db\Migration;

class m191216_090802_041_create_table_modulusreviews extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusreviews}}', [
            'id' => $this->primaryKey(),
            'prodId' => $this->integer(),
            'author' => $this->text(),
            'source' => $this->text(),
            'content' => $this->text(),
            'date' => $this->date(),
            'rating' => $this->float(),
        ], $tableOptions);

        $this->createIndex('modulusReviews_id_uindex', '{{%modulusreviews}}', 'id', true);
    }

    public function down()
    {
        $this->dropTable('{{%modulusreviews}}');
    }
}
