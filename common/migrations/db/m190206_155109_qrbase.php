<?php

use yii\db\Migration;

/**
 * Class m190206_155109_qrbase
 */
class m190206_155109_qrbase extends Migration {
    private $tableName = "mad_qrbase";

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName,
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(255),
                'sku' => $this->string(255),
                'claimed_on' => $this->date(),
                'hash' => $this->string(150),
                'views' => $this->integer(),
                'until' => $this->date()
            ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->tableName);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190206_155109_qrbase cannot be reverted.\n";

        return false;
    }
    */
}
