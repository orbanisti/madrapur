<?php
use yii\db\Migration;

/**
 * Class m190104_133751_test_users_table
 */
class m190104_133751_users_table extends Migration {

    private $tableName = "{{%user}}";

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
                    "id" => $this->primaryKey(),
                    "email" => $this->string(255)
                        ->notNull()
                        ->unique(),
                    "username" => $this->string(255)
                        ->notNull()
                        ->unique(),
                    "password" => $this->string(255)
                        ->notNull(),
                    "regdate" => $this->timestamp()
                        ->defaultExpression("CURRENT_TIMESTAMP"),
                    "status" => $this->tinyInteger(4)
                        ->notNull()
                        ->defaultValue(0)
                        ->comment("0 = nem aktivalt\n1 = aktiv\n2 = tiltott"),
                    "authKey" => $this->string(255)
                        ->notNull(),
                    "hashcode" => $this->string(32)
                        ->notNull(),
                    "rights" => $this->tinyInteger(4)
                        ->notNull()
                        ->comment("0 = regisztralt felhasznalo\n1 = moderator2\n2 = superadmin"),
                    "type" => $this->tinyInteger(4)
                        ->notNull(),
                    "lang_code" => $this->string(5)
                        ->notNull(),
                    "fb_id" => $this->bigInteger(20)
                        ->notNull(),
                    "dividend" => $this->integer(11)
                        ->notNull(),
                    "payment_in_advance" => $this->tinyInteger(4)
                        ->notNull()
                        ->defaultValue(0),
                    "agree_upload_info" => $this->tinyInteger(4)
                        ->notNull(),
                    "comment" => $this->string(1000)
                        ->defaultValue(""),
                    "commission" => $this->float()
                        ->notNull(),
                    "commission_type" => $this->tinyInteger(4)
                        ->notNull(),
                    "contract" => $this->integer(1)
                        ->notNull(),
                ], $tableOptions);

        $this->createIndex("email_UNIQUE", $this->tableName, "email", true);
        $this->createIndex("username_UNIQUE", $this->tableName, "username", true);

        $this->insert($this->tableName,
                [
                    "email" => "info@forweb.hu",
                    "username" => "forweb",
                    "password" => Yii::$app->security->generatePasswordHash("forweb4"), // "dfe3d77fcba52e671ac38720994bc0a4"
                    "regdate" => "2016-03-03 07:05:45",
                    "status" => 1,
                    "authKey" => "",
                    "hashcode" => "",
                    "rights" => 2,
                    "type" => 1,
                    "lang_code" => "en-GB",
                    "fb_id" => 0,
                    "dividend" => 10,
                    "payment_in_advance" => 0,
                    "agree_upload_info" => 0,
                    "comment" => "",
                    "commission" => 20,
                    "commission_type" => 0,
                    "contract" => 0
                ]);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->delete($this->tableName, [
            "username" => "forweb"
        ]);
        $this->dropIndex("username_UNIQUE", $this->tableName);
        $this->dropIndex("email_UNIQUE", $this->tableName);
        $this->dropTable($this->tableName);
    }

    /*
     * // Use up()/down() to run migration code without a transaction.
     * public function up() {
     *
     * }
     *
     * public function down() {
     * echo "m190104_133751_test_users_table cannot be reverted.\n";
     *
     * return false;
     * }
     */
}
