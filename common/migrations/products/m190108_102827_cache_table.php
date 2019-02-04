<?php
use yii\db\Migration;

/**
 * Class m190108_102827_cache_table
 */
class m190108_102827_cache_table extends Migration {

    private $tableName = "{{%cache}}";

    /**
     *
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;

        if ($this->db->driverName === "mysql") {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB";
        }

        $this->createTable($this->tableName,
                [
                    "id" => $this->char(128)
                        ->notNull(),
                    "expire" => $this->integer(11)
                        ->null(),
                    "data" => "LONGBLOB",
                ], $tableOptions);

        $this->addPrimaryKey("cachePK", $this->tableName, "id");
        $this->createIndex("indExpire", $this->tableName, "expire");
    }

    /**
     *
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropIndex("indExpire", $this->tableName);
        $this->dropPrimaryKey("id", $this->tableName);
        $this->dropTable($this->tableName);
    }

    /*
     * // Use up()/down() to run migration code without a transaction.
     * public function up()
     * {
     *
     * }
     *
     * public function down()
     * {
     * echo "m190108_102827_cache_table cannot be reverted.\n";
     *
     * return false;
     * }
     */
}
