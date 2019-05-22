<?php

namespace backend\modules\Payment\controllers;

use backend\modules\Order\models\Order;
use backend\modules\Reservations\models\Reservations;
use Yii;
use backend\controllers\Controller;
use yii\filters\VerbFilter;

/**
 * Controller for the `Payment` module
 */
class PaymentController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        return $this->render('admin');
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    //'simpleipn' => ['post'],
                    'create' => ['post'],
                ],
            ],
        ];

    }

    public function beforeAction($action) {
        // if ("simpleipn" === Yii::$app->controller->action->id)
            $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionPrePay() {

    }

    public static function actionPay($ids) {
        $reservations = Reservations::getReservationsByIds($ids);
        error_reporting(E_ALL|E_STRICT);
        ini_set('display_errors', '1');
        require_once(OTP.'sdk/config.php');
        require_once(OTP.'sdk/SimplePayment.class.php');

        $orderData = json_decode($reservations[0]->data);

        $cur = ($orderData->orderDetails->order_currency === 'EUR' || $orderData->orderDetails->order_currency === 'HUF') ? $orderData->orderDetails->order_currency : 'EUR';
        $orderCurrency = $cur;

        $lu = new \SimpleLiveUpdate($config, $orderCurrency);

        $simpleLang = (Yii::$app->language === "hu-HU") ? 'HU' : 'EN';
        $lu->setField("LANGUAGE", $simpleLang);

        /*
        if(!empty($reservations->coupon)) { // ha van kupon megadva, akkor kiszámoljuk a kedvezmény értékét
            $discount=($reservations->orderedproductsprice-$reservations->totalprice);
            $discount=($reservations->currency=='HUF')?((int)$discount):(number_format($discount, 2, '.', '')); // valutánként más formátum kell
            $lu->setField("DISCOUNT", $discount);
        }
        */

        $orderIds = [];
        foreach($reservations as $key => $order) {
            $data = json_decode($order->data);
            $orderDetails = $data->orderDetails;
            $bookingDetails = $data->bookingDetails;
            $orderTotal = $orderDetails->order_total;
            $sumPrice = 0.00;
            $orderIds[] = $order->id;

            foreach ($orderTotal as $price)
                $sumPrice += $price;

            $lu->addProduct(array(
                'name' => $bookingDetails->booking_name,							//product name [ string ]
                'code' => $bookingDetails->booking_product_id,							//merchant systemwide unique product ID [ string ]
                'info' => '',			//product description [ string ]
                'price' => $sumPrice, 								//product price [ HUF: integer | EUR, USD decimal 0.00 ]
                'vat' => 0,										//product tax rate [ in case of gross price: 0 ] (percent)
                'qty' => 1,							//product quantity [ integer ]
            ));
        }

        $order = new Order();
        $values= [
            'status' => 'pending',
            'transactionId' => '',
            'reservationIds' => json_encode($orderIds),
            'data' => ''
        ];

        $payOrderId = Order::insertOneReturn($order, $values);
        $lu->setField("ORDER_REF", $payOrderId);

        //Billing data
        $lu->setField("BILL_FNAME", $orderData->orderDetails->billing_first_name);
        $lu->setField("BILL_LNAME", $orderData->orderDetails->billing_last_name);
        $lu->setField("BILL_EMAIL", $orderData->orderDetails->billing_email);
        $lu->setField("BILL_PHONE", $orderData->orderDetails->billing_phone);
        $lu->setField("BILL_COMPANY", '');          		// optional
        //$lu->setField("BILL_FISCALCODE", " ");                  		// optional
        $lu->setField("BILL_COUNTRYCODE", $orderData->orderDetails->billing_country->value);
        $lu->setField("BILL_STATE", '');
        $lu->setField("BILL_CITY", $orderData->orderDetails->billing_city);
        $lu->setField("BILL_ADDRESS", $orderData->orderDetails->billing_address1);
        //$lu->setField("BILL_ADDRESS2", $orderData->orderDetails->billing_address2);		// optional
        $lu->setField("BILL_ZIPCODE", $orderData->orderDetails->billing_postcode);

        $lu->setField("DELIVERY_FNAME", $orderData->orderDetails->billing_first_name);
        $lu->setField("DELIVERY_LNAME", $orderData->orderDetails->billing_last_name);
        $lu->setField("DELIVERY_EMAIL", $orderData->orderDetails->billing_email);
        $lu->setField("DELIVERY_PHONE", $orderData->orderDetails->billing_phone);
        $lu->setField("DELIVERY_COMPANY", '');          		// optional
        //$lu->setField("DELIVERY_FISCALCODE", " ");                  		// optional
        $lu->setField("DELIVERY_COUNTRYCODE", $orderData->orderDetails->billing_country->value);
        $lu->setField("DELIVERY_STATE", '');
        $lu->setField("DELIVERY_CITY", $orderData->orderDetails->billing_city);
        $lu->setField("DELIVERY_ADDRESS", $orderData->orderDetails->billing_address1);
        //$lu->setField("DELIVERY_ADDRESS2", $orderData->orderDetails->billing_address2);		// optional
        $lu->setField("DELIVERY_ZIPCODE", $orderData->orderDetails->billing_postcode);

        $display = $lu->createHtmlForm('SimpleForm', 'auto', 'Start Payment');   // format: link, button, auto (auto is redirects to payment page immediately )

        $lu->errorLogger();

        return '<span style="display: none;">'.$display.'</span>';
    }

    public static function actionBackref() {
        $to      = 'alpe15.1992@gmail.com';
        $subject = 'ORDER';
        $message = 'Thank you!';
        $headers = 'From: web@budapestrivercruise.co.uk' . "\r\n" .
            'Reply-To: web@budapestrivercruise.co.uk' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        require_once(OTP."nogui/backref.php");
    }

    public static function actionTimeout() {
        require_once(OTP."nogui/timeout.php");
    }

    public static function actionIrn() {
        require_once(OTP."nogui/irn.php");
    }

    public static function actionIdn() {
        require_once(OTP."nogui/idn.php");
    }

    public static function actionIos() {
        require_once(OTP."nogui/ios.php");
    }

    public static function actionIpn() {
        $postData = Yii::$app->request->post();
        require_once(OTP."nogui/ipn.php");
    }
}
