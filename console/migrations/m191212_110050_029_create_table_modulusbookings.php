<?php

use yii\db\Migration;

class m191212_110050_029_create_table_modulusbookings extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modulusbookings}}', [
            'id' => $this->primaryKey(),
            'bookingId' => $this->string(32),
            'productId' => $this->string(32),
            'source' => $this->string()->notNull(),
            'data' => $this->text(),
            'invoiceDate' => $this->date()->notNull(),
            'bookingDate' => $this->date()->notNull(),
            'sellerId' => $this->string(),
            'sellerName' => $this->string(),
            'booking_cost' => $this->string(),
            'booking_product_id' => $this->string(),
            'booking_start' => $this->string(),
            'booking_end' => $this->string(),
            'allPersons' => $this->integer(),
            'customer_ip_address' => $this->string(),
            'paid_date' => $this->string(),
            'billing_first_name' => $this->string(),
            'billing_last_name' => $this->string(),
            'billing_email' => $this->string(),
            'billing_phone' => $this->string(),
            'order_currency' => $this->string(),
            'personInfo' => $this->text(),
            'invoiceMonth' => $this->string(),
            'notes' => $this->text(),
            'ticketId' => $this->string(),
            'isCancelled' => $this->string(),
            'paidMethod' => $this->string(),
            'iSellerId' => $this->string(),
            'iSellerName' => $this->string(),
            'status' => $this->string(20),
            'workshiftId' => $this->bigInteger(13),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%modulusbookings}}');
    }
}
