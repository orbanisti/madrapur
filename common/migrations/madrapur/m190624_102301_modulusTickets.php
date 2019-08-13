<?php

use yii\db\Schema;
use yii\db\Migration;

class m190624_102301_modulusTickets extends Migration {
    public $tableOptions = "";

    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            'modulus_ticket_blocks', [
                'id' => $this->primaryKey(),
                'startId' => $this->string(8)->notNull(),
                'assignedBy' => $this->integer()->notNull(),
                'assignedTo' => $this->integer()->null(),
                'frozen' => $this->boolean()->notNull()->defaultValue(0),
                'timestamp' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            ], $this->tableOptions
        );

        //TODO dynamic foreign key
        //$this->addForeignKey('fk_tb_start_id', 'modulus_ticket_blocks', 'startId', 'user', 'id', 'CASCADE',
        // 'CASCADE');

        $this->addForeignKey('fk_user_assigned_by', 'modulus_ticket_blocks', 'assignedBy', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey('fk_user_assigned_to', 'modulus_ticket_blocks', 'assignedTo', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->execute("
            CREATE PROCEDURE createTicketBlockTable
                (
                    IN TableName VARCHAR(19),
                    IN StartId VARCHAR(19),
                    IN Data VARCHAR(649)
                )
                BEGIN
                
                SET @DbTableName =
                    CONCAT('modulus_tb_', TableName);
                
                SET @CreateTableSQL =
                   CONCAT(
                     'CREATE TABLE IF NOT EXISTS ', @DbTableName, ' (
                        `ticketId` VARCHAR(255),
                        `sellerId` INT,
                        `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        `reservationId` VARCHAR(255)
                     );'
                   );
                PREPARE statement FROM @CreateTableSQL;
                EXECUTE statement;
                
                SET @SeedTableSQL =
                   CONCAT(
                     'INSERT INTO ', @DbTableName, ' (
                        `ticketId`
                     ) VALUES ', Data, ';'
                   );
                PREPARE statement FROM @SeedTableSQL;
                EXECUTE statement;
                END;
        ");
    }

    public function safeDown() {
        $this->dropTable('modulus_ticket_blocks');
        $this->execute('DROP PROCEDURE IF EXISTS createTicketBlockTable');
    }
}
