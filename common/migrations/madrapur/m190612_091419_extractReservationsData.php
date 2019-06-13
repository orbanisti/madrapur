<?php

use backend\modules\Reservations\models\Reservations;
use yii\db\Schema;
use yii\db\Migration;

class m190612_091419_extractReservationsData extends Migration {
    public $tableName = 'modulusBookings';
    public $tableOptions = "";
    public $columns = [
        "alterable" => [],
        "disposable" => [],
        "new" => [],
        "seedable" => [
            "boookingDetails:booking_cost" => null,
            "boookingDetails:booking_product_id" => null,
            "boookingDetails:booking_start" => null,
            "boookingDetails:booking_end" => null,
            "orderDetails:allPersons" => null,
            "orderDetails:customer_ip_address" => null,
            "orderDetails:paid_date" => null,
            "orderDetails:billing_first_name" => null,
            "orderDetails:billing_last_name" => null,
            "orderDetails:billing_email" => null,
            "orderDetails:billing_phone" => null,
            "orderDetails:order_currency" => null,
            "personInfo" => null,
        ],
    ];

    public function safeUp() {
        $reservationsData = Reservations::getCustomList('data');

        foreach ($reservationsData as $id => $data) {
            $dataObject = \yii\helpers\Json::decode($data);
            $update = [];

            foreach ($this->columns['seedable'] as $fullName => $defaultValue) {
                $explodedName = explode(":", $fullName);

                if (count($explodedName) > 1) {
                    $parentName = array_shift($explodedName);
                    $columnName = array_shift($explodedName);

                    if (isset($dataObject[$parentName][$columnName])) {
                        $update[$columnName] = $dataObject[$parentName][$columnName];
                    } else {
                        echo "`$columnName` missing from provided JSON at ID #$id.\n";
                    }

                } else {
                    $update[$fullName] = json_encode($dataObject[$fullName]);
                }
            }

            $this->update(
                $this->tableName,
                $update,
                "id = $id"
            );
        }

        $reservationsInvoiceDate = Reservations::getCustomList('invoiceDate');

        foreach ($reservationsInvoiceDate as $id => $invoiceDate) {
            $invoiceMonth = date("m", strtotime($invoiceDate));
          
            $this->update(
                $this->tableName,
                ["invoiceMonth" => $invoiceMonth],
                "id = $id"
            );
        }
    }

    public function safeDown() {
        $reservations = Reservations::getCustomList('data');

        foreach ($reservations as $id => $data) {
            $update = [];

            foreach ($this->columns['seedable'] as $fullName => $defaultValue) {
                $explodedName = explode(":", $fullName);

                if (count($explodedName) > 1) {
                    $columnName = array_pop($explodedName);

                    $update[$columnName] = $defaultValue;

                } else {
                    $update[$fullName] = $defaultValue;
                }
            }

            $this->update(
                $this->tableName,
                $update,
                "id = $id"
            );
        }

        $reservationsInvoiceDate = Reservations::getCustomList('invoiceDate');

        foreach ($reservationsInvoiceDate as $id => $invoiceDate) {
            $invoiceMonth = date("m", strtotime($invoiceDate));

            $this->update(
                $this->tableName,
                ["invoiceMonth" => null],
                "id = $id"
            );
        }
    }
}
