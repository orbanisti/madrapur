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
    use backend\modules\Reservations\models\ReservationsAdminSearchModel;
    use backend\modules\Tickets\models\TicketBlockSearchModel;
    use backend\modules\Tickets\models\TicketSearchModel;
    use common\commands\AddTicketToReservationCommand;
    use common\commands\AddToTimelineCommand;
    use common\commands\SendEmailCommand;
    use common\models\User;
    use kartik\icons\Icon;
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

            return $this->render(
                'createReact', [
                'data' => Json::encode($dataArray),
            ]
            );
        }

        public function actionMytransactions() {

            $searchModel = new Reservations();
            $dataProvider = $searchModel->searchMytransactions(Yii::$app->request->queryParams);
            $today = date('Y-m-d');
            $allTrans = $searchModel->searchMytransactions(Yii::$app->request->queryParams, $today);
            $eurTrans = $searchModel->searchMytransactions(Yii::$app->request->queryParams, $today, 'EUR');
            $hufTrans = $searchModel->searchMytransactions(Yii::$app->request->queryParams, $today, 'HUF');

            return $this->render(
                'mytransactions', [
                'dataProvider' => $allTrans,
                'allTransactionData' => $allTrans,
                'eurTransactionData' => $eurTrans,
                'hufTransactionData' => $hufTrans,

            ]
            );
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
            $allsources = new ProductSource();
            return $this->render(
                'admin', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'chartDataProvider' => $chartDataProvider,
                'dateImportModel' => $dateImportModel,
                'importResponse' => $importResponse,
                'allsources' => $allsources

            ]
            );
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

            $jsonResponse = json_decode(utf8_decode($response));
            //json decode junctiont ne változtasd másra!

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
                $data->updateDate = date('Y-m-d H:i:s');

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

                $ticketBlock = TicketBlockSearchModel::aSelect(TicketBlockSearchModel::class, '*', TicketBlockSearchModel::tableName(), 'assignedTo = ' . Yii::$app->user->id . ' AND isActive IS TRUE')->one();
                $ticket = TicketSearchModel::useTable('modulus_tb_' . $ticketBlock->returnStartId())::findOne(['reservationId' => null, 'status' => 'open']);

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
                    'ticketId' => $ticket->ticketId,
                ];
                $insertReservation = Reservations::insertOne($newReservarion, $values);

                if ($insertReservation) {
                    $findBooking = Reservations::aSelect(Reservations::class, '*', Reservations::tableName(), 'bookingId="tmpMad1"');
                    $booking = $findBooking->one();
                    $values = ['bookingId' => $booking->id];
                    Reservations::insertOne($booking, $values);

                    $updateResponse = '<span style="color:green">Reservation Successful</span>';

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

                    Yii::$app->commandBus->handle(
                        new AddTicketToReservationCommand(
                            [
                                'sellerId' => Yii::$app->user->getId(),
                                'timestamp' => date('Y-m-d H:i:s', time()),
                                'bookingId' => $booking->id,
                            ]
                        )
                    );

                    Yii::$app->commandBus->handle(
                        new SendEmailCommand(
                            [
                                'to' => 'alpe15.1992@gmail.com',
                                'from' => 'alpe15.1992@gmail.com',
                                'subject' => 'New reservation',
                                'type' => 'newReservation'
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
            return $this->render(
                'create', [
                    'model' => new Product(),
                    'disableForm' => $disableForm,
                    'myPrices' => $myprices,
                    'countPrices' => $countPrices,
                    'newReservation' => $updateResponse,

            ]);
        }

        public function actionCreate2() {
            if (!Yii::$app->user->can(Reservations::CREATE_BOOKING)) {
                throw new ForbiddenHttpException('userCan\'t');
            }

            $block = TicketBlockSearchModel::find()
                ->andFilterWhere(['=', 'assignedTo', Yii::$app->user->id])
                ->andWhere('isActive IS TRUE')
                ->one();
            if (!$block && !Yii::$app->user->can('administrator')) {

                throw new ForbiddenHttpException('Sorry you dont have an active Ticket Block');
            }

            $allProduct = Product::getAllProducts();

            $searchModel = new ReservationsAdminSearchModel();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $product = Yii::$app->request->post('Product');
            $productPrice = Yii::$app->request->post('ProductPrice');
            $totalprice = 0;

            $disableForm = 0;
            $myprices = [];
            Yii::error($_POST);
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
                /**
                 * Booking form step 2
                 */

                $paid_status = $_POST['paid_status'];

                $paid_method = $_POST['paid_method'];

                $paid_currency = $_POST['paid_currency'];

                $newReservarion = new Reservations();

                $data = new \stdClass();
                $data->boookingDetails = new \stdClass();
                $data->orderDetails = new \stdClass();

                $data->personInfo = [];
                $data->updateDate = date('Y-m-d H:i:s');

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
                $data->orderDetails->order_currency = $paid_currency;

                # $data=['boookingDetails'=> $booking->bookingDetails,'orderDetails'=>$booking->orderDetails,'personInfo'=>$booking->personInfo,'updateDate'=>date("Y-m-d H:i:s")];

                $source = 'unset';
                $imaStreetSeller = Yii::$app->authManager->getAssignment('streetSeller', Yii::$app->user->getId());
                $imaHotelSeller = Yii::$app->authManager->getAssignment('hotelSeller', Yii::$app->user->getId());

                if ($imaStreetSeller) {
                    $source = 'Street';
                }
                if ($imaHotelSeller) {
                    $source = 'Hotel';
                }

                $ticketBlock = TicketBlockSearchModel::aSelect(TicketBlockSearchModel::class, '*', TicketBlockSearchModel::tableName(), 'assignedTo = ' . Yii::$app->user->id . ' AND isActive IS TRUE')->one();
                $ticket = TicketSearchModel::useTable('modulus_tb_' . $ticketBlock->returnStartId())::findOne(['reservationId' => null, 'status' => 'open']);

                $firstName = '';
                $lastName = '';
                $orderNote = '';
                if (Yii::$app->request->post('firstName')) {
                    $firstName = Yii::$app->request->post('firstName');
                }
                if (Yii::$app->request->post('lastName')) {
                    $lastName = Yii::$app->request->post('lastName');
                }
                if (Yii::$app->request->post('orderNote')) {
                    $orderNote = Yii::$app->request->post('orderNote');
                }

                $values = [
                    'booking_cost' => $productPrice["discount"],
                    'invoiceMonth' => date('m'),
                    'invoiceDate' => date('Y-m-d'),
                    'bookingDate' => $productPrice['booking_date'],
                    'booking_start' => $data->boookingDetails->booking_start,
                    'source' => $source,
                    'productId' => $productPrice['product_id'],
                    'bookingId' => 'tmpMad1',
                    'data' => json_encode($data),
                    'sellerId' => Yii::$app->user->getId(),
                    'sellerName' => Yii::$app->user->identity->username,
                    'ticketId' => $ticket->ticketId,
                    'status' => $paid_status,
                    'paidMethod' => $paid_method,
                    'order_currency' => $paid_currency,
                    'billing_first_name' => $firstName,
                    'billing_last_name' => $lastName,
                    'notes' => $orderNote,
                ];

                if ($_POST['anotherSeller']) {
                    $originSellerId = $_POST['anotherSeller'];
                    $originSellerName = User::findIdentity($originSellerId)->username;
                    $foolSellerId = Yii::$app->user->id;
                    $foolSellerName = (Yii::$app->user->getIdentity($foolSellerId))->username;

                    $values['sellerId'] = $originSellerId;
                    $values['sellerName'] = $originSellerName;
                    $values['iSellerId'] = $foolSellerId;
                    $values['iSellerName'] = $foolSellerName;
                }

                $insertReservation = Reservations::insertOne($newReservarion, $values);

                Yii::error($insertReservation);
                if ($insertReservation) {
                    $findBooking = Reservations::aSelect(Reservations::class, '*', Reservations::tableName(), 'bookingId="tmpMad1"');
                    $booking = $findBooking->one();
                    $values = ['bookingId' => $booking->id];
                    Reservations::insertOne($booking, $values);

                    $updateResponse = sessionSetFlashAlert('success', '<i class="fas fa-check-square fa-lg   "></i> ' . 'Successful Reservation');;

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

                    Yii::$app->commandBus->handle(
                        new AddTicketToReservationCommand(
                            [
                                'sellerId' => Yii::$app->user->getId(),
                                'timestamp' => time(),
                                'bookingId' => $booking->id,
                            ]
                        )
                    );
                    Yii::$app->commandBus->handle(
                        new SendEmailCommand(
                            [
                                'to' => 'alpe15.1992@gmail.com',
                                'from' => 'alpe15.1992@gmail.com',
                                'subject' => 'New reservation',
                                'type' => 'newReservation'
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
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax(
                    'create2', [
                    'model' => new Product(),
                    'disableForm' => $disableForm,
                    'myPrices' => $myprices,
                    'countPrices' => $countPrices,
                    'newReservation' => $updateResponse,
                    'subView' => $this->renderPartial('assingui', ['model' => new Reservations()])
                ]
                );
            }

            return $this->render(
                'create2', [
                'model' => new Product(),
                'disableForm' => $disableForm,
                'myPrices' => $myprices,
                'countPrices' => $countPrices,
                'newReservation' => $updateResponse,
                'subView' => $this->renderPartial('assingui', ['model' => new Reservations()])
            ]
            );
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

        public function actionReporting() {
            $searchModel = new ProductAdminSearchModel();

            $users = User::find()->all();

            $today = date('Y-m-d');

            $gridColumns = [
                [
                    'label' => 'Persons',
                    'attribute' => 'bookedChairsCount',
                    'format' => 'html',
                    'value' => function ($model) {
                        $sellerBadge = '';
                        if (isset($model->iSellerName)) {

                            $sellerBadge = " <span class=\" badge bg-yellow\">" . $model->iSellerName . "</span>";
                        }

                        return $model->bookedChairsCount . ' ' . Icon::show(
                                'users', [
                                'class' => 'fa-lg', 'framework'
                                => Icon::FA
                            ]
                            ) . $sellerBadge;
                    }
                ],
                [
                    'label' => 'Cost',
                    'attribute' => 'bookingCost',

                    'format' => 'html',
                    'value' => function ($model) {

                        if ($model->orderCurrency == 'EUR') {
                            $currencySymbol = Icon::show(
                                'euro', [
                                'class' => 'fa-lg', 'framework'
                                => Icon::FA
                            ]
                            );
                        } else {
                            $currencySymbol = 'Ft';
                        }

                        return $model->bookingCost . ' ' . $currencySymbol;
                    }
                ],

            ];

            $reservationmodel = new Reservations();

            $userList = [];
            foreach ($users as $in => $user) {
                $userDataProvider = $reservationmodel->searchReservations(Yii::$app->request->queryParams, $user->id, $today);
                $userDataHuf = $reservationmodel->searchReservations(Yii::$app->request->queryParams, $user->id, $today, 'HUF');
                $userDataEur = $reservationmodel->searchReservations(Yii::$app->request->queryParams, $user->id, $today, 'EUR');
                $hufToday = Reservations::sumDataProvider($userDataHuf->models, 'bookingCost');
                $eurToday = Reservations::sumDataProvider($userDataEur->models, 'bookingCost');

                $userGrid = \kartik\grid\GridView::widget(
                    [
                        'dataProvider' => $userDataProvider,
                        'columns' => $gridColumns,
                        'pjax' => false,
                        'layout' => '{items}',
                        'toolbar' => [
                            [

                                'options' => ['class' => 'btn-group mr-2']
                            ],
                            '{export}',
                            '{toggleData}',
                        ],
                        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                        // set export properties
                        'export' => [
                            'fontAwesome' => true,

                        ],

                    ]
                );

                if ($user->hasRole('streetSeller')) {
                    $userList[] = "  <li><a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse" . $in . "\" 
        aria-expanded=\"false\"
               class=\"collapsed\"
               href=\"#\">
                <span class=\"btn bg-aqua\"> " . $user->username . "</span>
                <span class=\"float-right badge bg-green\">" . Icon::show(
                            'euro', [
                            'class' => 'fa-lg', 'framework'
                            => Icon::FA
                        ]
                        ) . $eurToday . "</span>
                <span class=\"float-right badge bg-green\">" . $hufToday . "</span>
                <span class=\"float-right badge bg-red\">" . $userDataProvider->getCount() . "</span></a></li>
        <div id=\"collapse" . $in . "\" class=\"panel-collapse collapse\" aria-expanded=\"false\" style=\"height: 0px;\">
            <div class=\"box-body\">
                " . $userGrid . "
            </div>
        </div>";
                }
            }

            return $this->render('reporting', ['userList' => $userList, 'searchModel' => $searchModel, 'today' => $today]);
        }

        public function actionDaye() {

            $currentProductId = Yii::$app->request->get('prodId');

            $searchModel = new Reservations();

            if ($currentProductId) {

                $currentProduct = Product::getProdById($currentProductId);
                $sourcesRows = ProductSource::getProductSourceIds($currentProductId);

                $selectedDate = \Yii::$app->request->get("date");
                $dataProvider = $searchModel->searchDay(Yii::$app->request->queryParams, $selectedDate, $sourcesRows, $currentProductId);
                $timeHours = Reservations::getProductTimeshours($currentProductId);

                $allDataproviders = [];

                foreach ($timeHours as $time) {

                    $tmpdataProvider = $searchModel->searchDayTime(Yii::$app->request->queryParams, $selectedDate, $sourcesRows, $currentProductId, $time);
                    $allDataproviders[$time] = $tmpdataProvider;
                }

                $takenChairsCount = Reservations::countTakenChairsOnDay($selectedDate, $sourcesRows);
                $availableChairsOnDay = $searchModel->availableChairsOnDay(Yii::$app->request->queryParams, $selectedDate, $sourcesRows, $currentProductId);
            }

            $passignedId = (Yii::$app->request->post('User'))['id'];
            $preservatinId = Yii::$app->request->post('reservation');
            if ($passignedId && $preservatinId) {
                $foundReservation = Reservations::find()->where(['id' => $preservatinId])->one();

                $assignedUser = User::find()->where(['id' => $preservatinId])->one();
                $assigneduser = User::findIdentity($passignedId);

                $assignData = [];
                $assignData['time'] = date('Y-m-d H:i:s', time());
                $assignData['by'] = Yii::$app->getUser()->identity->username;
                $assignData['from'] = $foundReservation->sellerName;
                $assignData['to'] = $assigneduser->username;

                if ($foundReservation) {
                    $Reservationobject = json_decode($foundReservation->data);
                    if (isset($Reservationobject->assignments) && is_array($Reservationobject->assignments)) {

                        array_unshift($Reservationobject->assignments, $assignData);
                    } else {
                        $Reservationobject->assignments[] = $assignData;
                    }

                    $foundReservation->data = json_encode($Reservationobject);
                    $foundReservation->sellerName = $assigneduser->username;
                    $foundReservation->save(false);
//                echo \GuzzleHttp\json_encode($foundReservation->data);
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Successful assignment<u>' . $preservatinId . '</u> reservation to ' . $foundReservation->sellerName));
                }
            }

            return $this->render(
                'dayEdit', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'model' => Reservations::class,
                'currentProduct' => $currentProduct,
                'currentDay' => Yii::$app->request->get('date'),
                'takenChairsCount' => $takenChairsCount,
                'availableChairs' => $availableChairsOnDay,
                'timesHours' => $timeHours,
                'allDataProviders' => $allDataproviders,
                'sources' => $sourcesRows,
                'selectedDate' => $selectedDate

            ]
            );
        }

        /**
         * @return array
         */
        public function actionCalcprice() {
            if (Yii::$app->request->isAjax) {

                $data = Yii::$app->request->post();
                if (isset($data['prices'])) {

                    $currID = $data['prodid'];
                    $query = ProductPrice::aSelect(ProductPrice::class, '*', ProductPrice::tableName(), 'product_id=' . $currID);
                    $myprices = $query->all();
                    $postedCurrency = $data['currency'];
                    $postedCustomPrice = $data['customPrice'];

                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    $productsBought = [];
                    Yii::error($data['prices']);
                    foreach ($data['prices'] as $priceId => $price) {
                        if ($price) {
                            $productsBought[$priceId] = $price;
                        }
                    }

                    $fullTotal = 0;

                    foreach ($productsBought as $priceId => $priceAmount) {

                        foreach ($myprices as $remotePrice) {

                            if ($remotePrice->id == $priceId) {
                                if ($postedCurrency == 'HUF') {
                                    $remotePrice = ProductPrice::eurtohuf($remotePrice);
                                }
                                $currentPrice = (int)$remotePrice->price;
                                (int)$fullTotal = (int)$fullTotal + (int)($currentPrice * $priceAmount);
                            }
                        }
                    }

                    return [
                        'search' => $fullTotal,
                        'customPrice' => (int)$postedCustomPrice,
                        'response' => 'price'
                    ];
                } else {
                    if (isset($data['date']) && isset($data['time'])) {
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                        $currID = $data['productId'];
                        $currDate = $data['date'];
                        $currTime = $data['time'];
                        $reservationModel = new Reservations();

                        $sources = ProductSource::getProductSourceIds($currID);
                        $currentProduct = Product::getProdById($currID);
                        $availableChairs = $currentProduct->capacity - $reservationModel->countTakenChairsOnDayTime($currDate, $sources, $currTime);
                        $progressBarlenght = round($availableChairs, -1);

                        $StreetHeader = "<span class=\"info-box-text\">Available places left:</span>
<span class=\"info-box-number\">$availableChairs</span>";

                        $capPercentage = round($availableChairs * 0.9, -1);
                        $HotelHeader = "<span class=\"info-box-text\">Remaining capacity:</span>
<span class=\"info-box-number\">$capPercentage+ </span>";

                        if (Yii::$app->user->can('hotelEditor')) {
                            $BoxInfo = $HotelHeader;
                        } else {
                            if (Yii::$app->user->can('streetSeller')) {
                                $BoxInfo = $StreetHeader;
                            } else {

                                $BoxInfo = $HotelHeader;
                            }
                        }

                        $capcolor = 'bg-blue';
                        if ($availableChairs < ($currentProduct->capacity) * 25 / 100) {
                            $capcolor = 'bg-red';
                        }
                        if ($availableChairs > ($currentProduct->capacity) * 45 / 100) {
                            $capcolor = 'bg-yellow';
                        }
                        if ($availableChairs > ($currentProduct->capacity) * 65 / 100) {
                            $capcolor = 'bg-blue';
                        }

                        $AvailableSpacesHtml = "
<div class=\"info-box $capcolor\">

<span class=\"info-box-icon\"><i class=\"fa fa-clock\"></i></span>

<div class=\"info-box-content\">
    " . $BoxInfo . "

    <div class=\"progress\">
        <div class=\"progress-bar\" style=\"width:$progressBarlenght%\"></div>
    </div>
    <span class=\"progress-description\">
                    for <strong>$currTime</strong>
                 </span>
</div>
<!-- /.info-box-content -->
</div>";

                        return [
                            'search' => "$AvailableSpacesHtml",
                            'response' => 'places'

                        ];
                    }
                }
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

            $model = new DateImport();
            $id = Yii::$app->request->get('id');
            $query = Reservations::aSelect(Reservations::class, '*', Reservations::tableName(), 'id=' . $id);

            $bookingInfo = $query->one();

            if (!Yii::$app->user->can('administrator')) {
                throw new ForbiddenHttpException('userCan\'t');
            }

            return $this->render('bookingEdit', ['model' => $model, 'backenddata' => $bookingInfo]);
        }

        public function actionView(){

            $id=Yii::$app->request->get('id');
            $reservation=Reservations::findOne($id);
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('view',['model'=>$reservation,'reservationModel'=>$reservation]);

            }

            return $this->render('view',['model'=>$reservation,'reservationModel'=>$reservation]);
        }

        public function actionBookingview() {

//        $model = new DateImport();
//        $request = Yii::$app->request;
//        $id = $request->get('id');
//        $query = Reservations::aSelect(Reservations::class, '*', Reservations::tableName(), 'id=' . $id);
//
//        $bookingInfo = $query->one();
//
//        $backendData = $bookingInfo;
            return $this->render('bookingView');
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
            $dataProvider->setSort(
                [

                    'defaultOrder' => [
                        'id' => SORT_DESC
                    ]
                ]
            );

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
            if (!Yii::$app->user->can(Reservations::VIEW_BOOKINGS) && !Yii::$app->user->can(Reservations::VIEW_OWN_BOOKINGS)) {
                throw new ForbiddenHttpException('userCan\'t');
            }

            $searchModel = new ReservationsAdminSearchModel();
            $dataProvider = $searchModel->searchAllreservations(Yii::$app->request->queryParams);
            $chartDataProvider = $searchModel->searchChart(Yii::$app->request->queryParams);

            $dataProvider->setSort(
                [
                    'defaultOrder' => [
                        'id' => SORT_DESC
                    ]
                ]
            );

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