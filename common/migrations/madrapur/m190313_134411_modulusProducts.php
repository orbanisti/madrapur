<?php

use yii\db\Schema;
use yii\db\Migration;

class m190313_134411_modulusProducts extends Migration {
    public $tableName = "modulusProducts";
    public $tableOptions = '';

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            $this->tableName, [
                'id' => $this->primaryKey(),
                'currency'=> $this->string(12)->notNull()->unique(),
                'status'=>$this->string(12)->notNull(),
                'title' => $this->string(500)->notNull(),
                'description' =>  $this->string(5000)->notNull(),
                'short_description' =>  $this->string(3000)->notNull(),
                'thumbnail'=>  $this->string(500)->notNull(),
                'images'=>  $this->string(1000)->notNull(),
                'category'=>$this->string(1000)->notNull(),
                'start_date'=>$this->string(50)->notNull(),
                'end_date'=>$this->string(50)->notNull(),
                'capacity'=>$this->string(50)->notNull(),
                'duration'=>$this->string(50)->notNull()
            ], $this->tableOptions
        );
        $this->insert($this->tableName, [
            'id' => "1",
            'currency'=>'HUF'
        ]);
    }

    public function safeDown() {
        $this->dropTable($this->tableName);
    }
}
