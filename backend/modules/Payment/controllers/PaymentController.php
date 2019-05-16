<?php

namespace backend\modules\Payment\controllers;

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
        if ("simpleipn" === Yii::$app->controller->action->id)
            $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionPrePay() {

    }

    public static function actionPay($id) {
        $order = Reservations::findOne($id);

        error_reporting(E_ALL|E_STRICT);
        ini_set('display_errors', '1');
        require_once(OTP.'sdk/config.php');
        require_once(OTP.'sdk/SimplePayment.class.php');

        $cur=($order->currency=='EUR' || $order->currency=='HUF')?$order->currency:'HUF';
        $orderCurrency = $cur;
        $payOrderId = (int)'0'.$order->order_id;

        $lu = new \SimpleLiveUpdate($config, $orderCurrency);
        $lu->setField("ORDER_REF", $payOrderId);

        $simplelang=(Yii::$app->language=="hu-HU")?'HU':'EN';
        $lu->setField("LANGUAGE", $simplelang);

        if(!empty($order->coupon)) { // ha van kupon megadva, akkor kiszámoljuk a kedvezmény értékét
            $discount=($order->orderedproductsprice-$order->totalprice);
            $discount=($order->currency=='HUF')?((int)$discount):(number_format($discount, 2, '.', '')); // valutánként más formátum kell
            $lu->setField("DISCOUNT", $discount);
        }

        foreach($order->orderedproducts as $key=>$product) {
            $details = Json::decode($product->params, true);
            $lu->addProduct(array(
                'name' => $details['title'],							//product name [ string ]
                'code' => 'ML'.$product->product_id,							//merchant systemwide unique product ID [ string ]
                'info' => '',			//product description [ string ]
                'price' => $product->sum_price, 								//product price [ HUF: integer | EUR, USD decimal 0.00 ]
                'vat' => 0,										//product tax rate [ in case of gross price: 0 ] (percent)
                'qty' => 1							//product quantity [ integer ]
            ));
        }

        //Billing data
        $lu->setField("BILL_FNAME", $order->address->name);
        $lu->setField("BILL_LNAME", '');
        $lu->setField("BILL_EMAIL", $order->address->email);
        $lu->setField("BILL_PHONE", $order->address->phone);
        //$lu->setField("BILL_COMPANY", "Company name");          		// optional
        //$lu->setField("BILL_FISCALCODE", " ");                  		// optional
        $lu->setField("BILL_COUNTRYCODE", $order->address->country);
        $lu->setField("BILL_STATE", "");
        $lu->setField("BILL_CITY", $order->address->city);
        $lu->setField("BILL_ADDRESS", $order->address->address);
        //$lu->setField("BILL_ADDRESS2", "Second line address");		// optional
        $lu->setField("BILL_ZIPCODE", $order->address->zipcode);

        $lu->setField("DELIVERY_FNAME", $order->address->name);
        $lu->setField("DELIVERY_LNAME", '');
        $lu->setField("DELIVERY_EMAIL", $order->address->email);
        $lu->setField("DELIVERY_PHONE", $order->address->phone);
        $lu->setField("DELIVERY_COUNTRYCODE", $order->address->country);
        $lu->setField("DELIVERY_STATE", "");
        $lu->setField("DELIVERY_CITY", $order->address->city);
        $lu->setField("DELIVERY_ADDRESS", $order->address->address);
        //$lu->setField("DELIVERY_ADDRESS2", "Second line address");	// optional
        $lu->setField("DELIVERY_ZIPCODE", $order->address->zipcode);

        $display = $lu->createHtmlForm('SimpleForm', 'auto', 'Start Payment');   // format: link, button, auto (auto is redirects to payment page immediately )

        $lu->errorLogger();

        header ('Content-type: text/html; charset=utf-8');
        echo '<span style="display: none;">'.$display.'</span>';
    }

    public static function actionBackref() {
        require_once(OTP."backref.php");
    }

    public static function actionTimeout() {
        require_once(OTP."timeout.php");
    }

    public static function actionIrn() {
        require_once(OTP."irn.php");
    }

    public static function actionIdn() {
        require_once(OTP."idn.php");
    }

    public static function actionIos() {
        require_once(OTP."ios.php");
    }
}
