<?php

use yii\db\Schema;
use yii\db\Migration;

class m190612_085202_expandReservationsData extends Migration {
    public $tableName = "modulusBookings";
    public $tableOptions = "";
    public $columns = [
        "alterable" => [],
        "disposable" => [],
        "new" => [
            "booking_cost" => Schema::TYPE_STRING,
            "booking_product_id" => Schema::TYPE_STRING,
            "booking_start" => Schema::TYPE_STRING,
            "booking_end" => Schema::TYPE_STRING,
            "allPersons" => Schema::TYPE_INTEGER,
            "customer_ip_address" => Schema::TYPE_STRING,
            "paid_date" => Schema::TYPE_STRING,
            "billing_first_name" => Schema::TYPE_STRING,
            "billing_last_name" => Schema::TYPE_STRING,
            "billing_email" => Schema::TYPE_STRING,
            "billing_phone" => Schema::TYPE_STRING,
            "order_currency" => Schema::TYPE_STRING,
            "personInfo" => Schema::TYPE_TEXT,
            "invoiceMonth" => Schema::TYPE_STRING,
        ],
    ];

    public function safeUp() {
        foreach ($this->columns['new'] as $name => $type) {
            $this->addColumn(
                $this->tableName,
                $name,
                $type
            );
        }
    }

    public function safeDown() {
        foreach ($this->columns['new'] as $name => $type) {
            $this->dropColumn(
                $this->tableName,
                $name
            );
        }
    }
}
