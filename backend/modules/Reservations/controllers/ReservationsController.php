<?php

namespace backend\modules\Reservations\controllers;

use backend\controllers\Controller;
use backend\modules\Product\models\Product;
use backend\modules\Product\models\ProductAdminSearchModel;
use backend\modules\Product\models\ProductPrice;
use backend\modules\Product\models\ProductSource;
use backend\modules\Product\models\ProductTime;
use backend\modules\Reservations\models\DateImport;
use backend\modules\Reservations\models\Reservations;
use backend\modules\Reservations\models\ReservationsAdminInfoSearchModel;
use backend\modules\Reservations\models\ReservationsAdminSearchModel;
use backend\modules\Tickets\models\TicketBlock;
use backend\modules\translation\models\Source;
use common\commands\AddToTimelineCommand;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;

/**
 * ReservationsController implements the CRUD actions for ReservationsModel.
 */
class ReservationsController extends Controller {

    /**
     * @param bool $id
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionCreateReact($id = false) {
        if (!Yii::$app->user->can(Reservations::CREATE_BOOKING)) {
            throw new ForbiddenHttpException('userCan\'t');
        }

        $searchModel = new ReservationsAdminSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (!$id) {
            $where = '1 = 1';
        } else {
            $where = 'id = ' . $id;
        }

        $data = ProductAdminSearchModel::aSelect(
            Product::class,
            ['id', 'title', 'currency'],
            Product::tableName(),
            $where
        )->all();

        $dataArray = ArrayHelper::toArray($data);

        foreach ($dataArray as $k => $v) {
            $id = $v['id'];

            $myTimes = ProductTime::aSelect(ProductTime::class, '*', ProductTime::tableName(), 'product_id=' . $id)->all();
            $dataArray[$k]['times'] = ArrayHelper::toArray($myTimes);

            $myPrices = ProductTime::aSelect(ProductPrice::class, '*', ProductPrice::tableName(), 'product_id=' . $id)->all();
            $dataArray[$k]['prices'] = ArrayHelper::toArray($myPrices);
        }

        return $this->render('createReact', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'data' => Json::encode($dataArray),
        ]);
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionAdmin() {
        if (!Yii::$app->user->can(Reservations::ACCESS_BOOKINGS_ADMIN)) {
            throw new ForbiddenHttpException('userCan\'t');
        }

        $searchModel = new Reservations();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $chartDataProvider = $searchModel->searchChart(Yii::$app->request->queryParams);
        $dateImportModel = new DateImport();
        $request = Yii::$app->request;
        $dateImport = $request->post('DateImport');
        $response = $this->importDateRange($dateImport['source'], $dateImport['dateFrom'], $dateImport['dateTo']);
        $importResponse = 'No Import initiated';

        if ($response) {
            $updateCounter = 0;
            $newRecordCounter = 0;

            foreach ($response as $booking) {
                if (isset($booking->orderDetails->paid_date)) {

                    if (!isset($booking->personInfo)) {
                        $booking->personInfo = '';
                    }
                    if (!isset($booking->orderDetails->paid_date)) {
                        $booking->orderDetails->paid_date = '2019-01-01';
                    }

                    # if(!isset($booking->orderDetails->paid_date)) $booking->orderDetails->paid_date=;

                    $data = ['boookingDetails' => $booking->bookingDetails, 'orderDetails' => $booking->orderDetails, 'personInfo' => $booking->personInfo, 'updateDate' => date("Y-m-d H:i:s")];

                    if ($booking->bookingDetails->booking_cost > 200000 && $booking->orderDetails->order_currency == 'EUR') {
                        continue;
                    }

                    $values = [
                        'invoiceMonth' => date('m', strtotime($booking->orderDetails->paid_date)),
                        'booking_cost' => $booking->bookingDetails->booking_cost,
                        'bookingId' => $booking->bookingId,
                        'productId' => $booking->bookingDetails->booking_product_id,
                        'source' => $dateImport['source'],
                        'invoiceDate' => $booking->orderDetails->paid_date,
                        'bookingDate' => $booking->bookingDetails->booking_start,
                        'data' => Json::encode($data)
                    ];

                    /**
                     * $bookingVerifyComd verifies if booing alreadz exists if so it will be updated, else new record creted
                     * TODO Needs Speed Improvement @palius
                     */
                    $query = Reservations::aSelect(Reservations::class, '*', Reservations::tableName(), 'bookingId=' . $booking->bookingId);

                    $rows = $query->one();

                    if (isset($rows)) {
                        $updateCounter += 1;
                        $model = $rows;
                    } else {
                        $model = new Reservations();
                        $newRecordCounter += 1;
                    }

                    $columns = [
                        "booking_cost",
                        "booking_product_id",
                        "booking_start",
                        "booking_end",
                        "allPersons",
                        "customer_ip_address",
                        "paid_date",
                        "billing_first_name",
                        "billing_last_name",
                        "billing_email",
                        "billing_phone",
                        "order_currency",
                    ];

                    foreach ($data as $id => $dataSet) {
                        foreach ($columns as $colName) {
                            if (isset($dataSet->$colName)) {
                                $values[$colName] = $dataSet->$colName;
                            }
                        }
                    }

                    if (Reservations::insertOne($model, $values)) {
                        $importResponse = 'Import Completed <br/><strong>' . $updateCounter . ' </strong>updated <br/><strong>' . $newRecordCounter . '</strong> imported ';
                    } else {
                        $importResponse = 'Import failed';
                        //show an error message
                    }
                    #$importResponse=$rows;

                }
            }
        }
        $allsources=new ProductSource();
        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'chartDataProvider' => $chartDataProvider,
            'dateImportModel' => $dateImportModel,
            'importResponse' => $importResponse,
            'allsources'=>$allsources

        ]);
    }

    /**
     * Lists all Products models.
     *
     * @return mixed
     */
    public function importDateRange($source, $dateFrom, $dateTo) {

        $dateFrom = date('Y-m-d', strtotime($dateFrom));
        $dateTo = date('Y-m-d', strtotime($dateTo));
        $url = $source . '/wp-json/bookings/v1/start/' . $dateFrom . '/end/' . $dateTo;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        curl_close($curl);

        $jsonResponse = Json::decode(utf8_decode($response));

        return $jsonResponse;
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     * @throws \Throwable
     * @throws \trntv\bus\exceptions\MissingHandlerException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate() {
        if (!Yii::$app->user->can(Reservations::CREATE_BOOKING)) {
            throw new ForbiddenHttpException('userCan\'t');
        }

        $allProduct = Product::getAllProducts();

        $searchModel = new ReservationsAdminSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $product = Yii::$app->request->post('Product');
        $productPrice = Yii::$app->request->post('ProductPrice');
        $totalprice = 0;

        $disableForm = 0;
        $myprices = [];
        if ($product) {
            $disableForm = 1;
            $query = ProductPrice::aSelect(ProductPrice::class, '*', ProductPrice::tableName(), 'product_id=' . $product['title']);
            $myprices = $query->all();
            $countPrices = $query->count();
        }
        if (!isset($countPrices)) {
            $countPrices = 0;
        }
        if ($productPrice) {

            $newReservarion = new Reservations();

            $data = new \stdClass();
            $data->boookingDetails = new \stdClass();
            $data->orderDetails = new \stdClass();

            $data->personInfo = [];
            $data->updateDate = date('Y-m-d h:m:s');

            $query = ProductPrice::aSelect(ProductPrice::class, '*', ProductPrice::tableName(), 'product_id=' . $productPrice["product_id"]);
            $myprices = $query->all();
            foreach ($myprices as $i => $price) {
                if ($productPrice['description'][$i]) {
                    $newObj = new \stdClass();
                    $newObj->name = $price->name;
                    $newObj->purchaseNumber = $productPrice['description'][$i];
                    $newObj->oneCost = $price->price;
                    $data->personInfo[] = $newObj;
                }
            }

            $countPersons = 0;
            foreach ($productPrice['description'] as $price) {
                if ($price) {
                    $countPersons += $price;
                }
            }
            #echo $countPersons;

            #var_dump($data);
            $data->boookingDetails->booking_cost = $productPrice["discount"];
            $data->boookingDetails->booking_product_id = $productPrice["product_id"];
            $data->boookingDetails->booking_start = $productPrice['booking_date'] . ' ' . $productPrice['time_name'] . ':00';
            $data->boookingDetails->booking_end = $productPrice['booking_date'] . ' ' . $productPrice['time_name'] . ':00';
            $data->orderDetails->paid_date = date('Y-m-d');
            $data->orderDetails->allPersons = $countPersons;
            $data->orderDetails->order_currency = 'EUR';

            # $data=['boookingDetails'=> $booking->bookingDetails,'orderDetails'=>$booking->orderDetails,'personInfo'=>$booking->personInfo,'updateDate'=>date("Y-m-d H:i:s")];

            $data = Json::encode($data);

            $source = 'unset';
            $imaStreetSeller = Yii::$app->authManager->getAssignment('streetSeller', Yii::$app->user->getId());
            $imaHotelSeller = Yii::$app->authManager->getAssignment('hotelSeller', Yii::$app->user->getId());

            if ($imaStreetSeller) {
                $source = 'Street';
            }
            if ($imaHotelSeller) {
                $source = 'Hotel';
            }

            $values = [
                'booking_cost' => $productPrice["discount"],
                'invoiceMonth' => date('m'),
                'invoiceDate' => date('Y-m-d'),
                'bookingDate' => $productPrice['booking_date'],
                'source' => $source,
                'productId' => $productPrice['product_id'],
                'bookingId' => 'tmpMad1',
                'data' => $data,
                'sellerId' => Yii::$app->user->getId(),
                'sellerName' => Yii::$app->user->identity->username,
            ];
            $insertReservation = Reservations::insertOne($newReservarion, $values);

            if ($insertReservation) {
                $findBooking = Reservations::aSelect(Reservations::class, '*', Reservations::tableName(), 'bookingId="tmpMad1"');
                $booking = $findBooking->one();
                $values = ['bookingId' => $booking->id];
                Reservations::insertOne($booking, $values);

                $updateResponse = '<span style="color:green">Reservation Successful</span>';

                TicketBlock::getDb();

                Yii::$app->commandBus->handle(
                    new AddToTimelineCommand(
                        [
                            'category' => 'bookings',
                            'event' => 'newBooking',
                            'data' => [
                                'public_identity' => Yii::$app->user->getIdentity(),
                                'user_id' => Yii::$app->user->getId(),
                                'created_at' => time()
                            ]
                        ]
                    )
                );
            } else {
                $updateResponse = '<span style="color:red">Reservation Failed</span>';
                //show an error message
            }
        }
        if (!isset($updateResponse)) {
            $updateResponse = '';
        }
        return $this->render('create', [
            'model' => new Product(),
            'disableForm' => $disableForm,
            'myPrices' => $myprices,
            'countPrices' => $countPrices,
            'newReservation' => $updateResponse,

        ]);
    }

    /**
     * @return array
     */
    public function actionGettimes() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $id = $data['id'];
            $query = ProductTime::aSelect(ProductTime::class, '*', ProductTime::tableName(), 'product_id=' . $id);
            $mytimes = $query->all();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'search' => $mytimes,
            ];
        }
        return [];
    }

    /**
     * @return array
     */
    public function actionCalcprice() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $currID = $data['productId'];
            $query = ProductPrice::aSelect(ProductPrice::class, '*', ProductPrice::tableName(), 'product_id=' . $currID);
            $myprices = $query->all();

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $productsBought = [];
            foreach ($data['prices'] as $priceId => $price) {
                if ($price) {
                    $productsBought[$priceId] = $price;
                }
            }

            $fullTotal = 0;

            foreach ($productsBought as $priceId => $priceAmount) {

                foreach ($myprices as $remotePrice) {
                    if ($remotePrice->id == $priceId) {
                        $currentPrice = (int)$remotePrice->price;
                        $fullTotal = $fullTotal + ($currentPrice * $priceAmount);
                    }
                }
            }

            return [
                'search' => $fullTotal,
            ];
        }
        return [];
    }

    /**
     * @return array|string
     */
    public function actionGetprices() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $id = $data['id'];
            $query = ProductPrice::aSelect(ProductPrice::class, '*', ProductPrice::tableName(), 'product_id=' . $id);
            $myprices = $query->all();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->renderPartial('prices');
        }
        return [];
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionBookingedit() {
        if (!Yii::$app->user->can(Reservations::EDIT_BOOKING) || !Yii::$app->user->can(Reservations::EDIT_OWN_BOOKING)) {
            throw new ForbiddenHttpException('userCan\'t');
        }

        $model = new DateImport();
        $request = Yii::$app->request;
        $id = $request->get('id');
        $query = Reservations::aSelect(Reservations::class, '*', Reservations::tableName(), 'id=' . $id);

        $bookingInfo = $query->one();

        $backendData = $bookingInfo;
        return $this->render('bookingEdit', ['model' => $model, 'backenddata' => $backendData]);
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionMyreservations() {
        if (!Yii::$app->user->can(Reservations::VIEW_OWN_BOOKINGS)) {
            throw new ForbiddenHttpException('userCan\'t');
        }

        $searchModel = new ReservationsAdminSearchModel();
        $dataProvider = $searchModel->searchMyreservations(Yii::$app->request->queryParams);
        $dataProvider->setSort([

            'defaultOrder' => [
                'id' => SORT_DESC
            ]
        ]);

        $monthlySold = $searchModel->getMonthlyBySeller(Yii::$app->user->identity->username);
        $todaySold = $searchModel->getTodayBySeller(Yii::$app->user->identity->username);
        $myTicketBook = $searchModel->getTicketBookBySeller();

        return $this->render(
            'myreservations',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'monthlySold' => $monthlySold,
                'todaySold' => $todaySold,
                'nextTicketId' => isset($myTicketBook->startId) ? $myTicketBook->startId : 'unset',
                'startTicketId' => isset($myTicketBook->startId) ? $myTicketBook->startId : null,
            ]
        );
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionAllreservations() {
        if (!Yii::$app->user->can(Reservations::VIEW_BOOKINGS) && !Yii::$app->user->can
            (Reservations::VIEW_OWN_BOOKINGS)) {
            throw new ForbiddenHttpException('userCan\'t');
        }

        $searchModel = new ReservationsAdminSearchModel();
        $dataProvider = $searchModel->searchAllreservations(Yii::$app->request->queryParams);
        $chartDataProvider = $searchModel->searchChart(Yii::$app->request->queryParams);

        $dataProvider->setSort([
            'defaultOrder' => [
                'id' => SORT_DESC
            ]
        ]);

        return $this->render(
            'allreservations',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'chartDataProvider' => $chartDataProvider,
            ]
        );
    }
}