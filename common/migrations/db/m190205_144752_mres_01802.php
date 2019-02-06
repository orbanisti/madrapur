<?php

use yii\db\Migration;

/**
 * Class m190205_144752_mres_01802
 */
class m190205_144752_mres_01802 extends Migration {
    private $tableName = "mres_1802";

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
                'uuid' => $this->string(32),
                'source' => $this->string(255)
                    ->notNull(),
                'data' => $this->string(1000),
                'invoice_date' => $this->date()
                    ->notNull(),
                'reservation_date' => $this->date()
                    ->notNull(),
            ], $tableOptions);

        $this->insert($this->tableName, [
            'uuid' => "HEX(UUID())",
            'source' => "utca1",
            'data' => "{}",
            'invoice_date' => "2018-02-05",
            'reservation_date' => "2018-08-20"
        ]);

        $this->insert($this->tableName, [
            'uuid' => "HEX(UUID())",
            'source' => "utca2",
            'data' => "{}",
            'invoice_date' => "2018-02-05",
            'reservation_date' => "2018-08-20"
        ]);

        $this->insert($this->tableName, [
            'uuid' => "HEX(UUID())",
            'source' => "online",
            'data' => "{}",
            'invoice_date' => "2018-02-05",
            'reservation_date' => "2018-08-20"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->delete($this->tableName, [
            "data" => "{}"
        ]);
        $this->dropTable($this->tableName);
    }
}
