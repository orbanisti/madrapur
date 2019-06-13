<?php

namespace backend\modules\Statistics\controllers;

use backend\modules\Reservations\models\ReservationsAdminSearchModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Yii;
use backend\controllers\Controller;

/**
 * Controller for the `Statistics` module
 */
class StatisticsController extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        $searchModel = new ReservationsAdminSearchModel();
        $dataProvider = $searchModel->searchAllreservations(Yii::$app->request->queryParams);

        $postedDateRange = Yii::$app->request->post('Product');

        $startDate = date("Y-m-01");
        $endDate = date("Y-m-t");

        if ($postedDateRange) {
            $explodedRange = explode(" - ", $postedDateRange['start_date']);
            $startDate = $explodedRange[0];
            $endDate = $explodedRange[1];
        }

        $chartDataProvider = $searchModel->searchChartForStats($startDate, $endDate);

        $chartProvider=$chartDataProvider->query->all();
        $series=array();
        $price=array();
        $hotelPrice=array();
        $streetPrice=array();
        $sources=array();
        $streetSellers=array();
        $hotelSellers=array();


        /**
         * Visualise Chart on Bookings data TODO: Sort, Import Refunded Bookings + Voucher Orders
         */
        foreach($chartProvider as $data){
            if(!in_array($data->source, $sources)){
                $sources[]=$data->source;
            }

            if($data->source == 'Hotel'){
                if(!in_array($data->sellerName,$hotelSellers)){
                    $hotelSellers[]=$data->sellerName;
                }
            }

            if( $data->source == 'Street'){
                if(!in_array($data->sellerName,$streetSellers)){
                    $streetSellers[]=$data->sellerName;
                }
            }

            $data->data = json_decode($data->data);

            if(isset($data->data->orderDetails)) {
                $cBookingPaidDate = date('Y-m-d', strtotime($data->invoiceDate));

                if(!isset($data->data->orderDetails->order_currency)) {
                    $cBookingCurrency='EUR';
                }else{
                    $cBookingCurrency = $data->data->orderDetails->order_currency;
                }

                if(isset($data->data->boookingDetails->booking_cost)) {
                    $cBookingTotal = $data->data->boookingDetails->booking_cost;
                }
                else{
                    $cBookingTotal ='0';//**Todo  update $data booking cost;
                }

                if ($cBookingCurrency != 'EUR') {
                    $cBookingTotal = intval($cBookingTotal) / 300;
                }

                /**
                 * A fenti if azt az esetet vizsgálja ha az order total mégse annyi mint a booking total pl kupon/teszt vásárlás
                 */
                if (isset($price[$cBookingPaidDate][$data->source]) && isset($price[$cBookingPaidDate][$data->sellerName])) {
                    if(isset($data->data->orderDetails->order_total)) {
                        if ($data->data->orderDetails->order_total == '0') {
                            $cBookingTotal = 0;
                        }
                    }

                    $price[$cBookingPaidDate][$data->source] += intval($cBookingTotal);

                    if ($data->source === "Hotel") {
                        $hotelPrice[$cBookingPaidDate][$data->sellerName] += intval($cBookingTotal);
                    } elseif ($data->source === "Street") {
                        $streetPrice[$cBookingPaidDate][$data->sellerName] += intval($cBookingTotal);
                    }
                } else {
                    if(isset($data->data->orderDetails->order_total)) {
                        if ($data->data->orderDetails->order_total == '0') {
                            $cBookingTotal = 0;
                        }
                    }

                    $price[$cBookingPaidDate][$data->source] = intval($cBookingTotal);

                    if ($data->source === "Hotel") {
                        $hotelPrice[$cBookingPaidDate][$data->sellerName] = intval($cBookingTotal);
                    } elseif ($data->source === "Street") {
                        $streetPrice[$cBookingPaidDate][$data->sellerName] = intval($cBookingTotal);
                    }
                }
            }
        }

        foreach ($sources as $source) {
            $entity['name']=$source;
            $entity['data']=array();
            foreach ($price as $pDate=>$pValue){
                if(isset($pValue[$source])) {
                    $oneDate = array(0 => date('Y-m-d',strtotime($pDate)), 1 => $pValue[$source]);
                    $entity['data'][] = $oneDate;
                }
            }

            /**
             * $array[] is 3x faster than array push
             */
            $series[]=$entity;
        }

        $hotelseries = [];
        foreach ($hotelSellers as $source) {
            $entity['name']=$source;
            $entity['data']=array();
            foreach ($hotelPrice as $pDate=>$pValue){
                if(isset($pValue[$source])) {
                    $oneDate = array(0 => date('Y-m-d',strtotime($pDate)), 1 => $pValue[$source]);
                    $entity['data'][] = $oneDate;
                }
            }

            /**
             * $array[] is 3x faster than array push
             */
            $hotelseries[]=$entity;
        }


        $streetseries = [];
        foreach ($streetSellers as $source) {
            $entity['name']=$source;
            $entity['data']=array();
            foreach ($streetPrice as $pDate=>$pValue){
                if(isset($pValue[$source])) {
                    $oneDate = array(0 => date('Y-m-d',strtotime($pDate)), 1 => $pValue[$source]);
                    $entity['data'][] = $oneDate;
                }
            }

            /**
             * $array[] is 3x faster than array push
             */
            $streetseries[]=$entity;
        }

        /**
         * Sorba teszem itt a dátumokat
         */
        $finalSeries=[];
        $finalStreetSeries=[];
        $finalHotelSeries=[];

        foreach ($series as $serie){
            usort($serie["data"], array("self", "sortFunction"));
            $finalSeries[]=$serie;
        }

        foreach ($streetseries as $serie){
            usort($serie["data"], array("self", "sortFunction"));
            $finalStreetSeries[]=$serie;
        }
        foreach ($hotelseries as $serie){
            usort($serie["data"], array("self", "sortFunction"));
            $finalHotelSeries[]=$serie;
        }

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'chartDataProvider' => $chartDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'finalSeries' => $finalSeries,
            'finalStreetSeries' => $finalStreetSeries,
            'finalHotelSeries' => $finalHotelSeries,
        ]);
    }

    function sortFunction( $a, $b ) {
        return strtotime($a["0"]) - strtotime($b["0"]);
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}