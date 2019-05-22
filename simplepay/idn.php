<?php

 	/**
	 * Optional error riporting
	 */	   
	error_reporting(E_ALL|E_STRICT);
	ini_set('display_errors', '1');
	
	/**
	 * Import config data
	 */		
	require_once("sdk/config.php");

	
	/**
	 * Import PayUPaymentExtra class
	 */
	require_once('sdk/SimplePayment.class.php');

	
	/**
	 * Test helper functions  -- ONLY FOR TEST!
	 */
	require_once('demo/demo_functions.php');
		
	$orderCurrency = (isset($_REQUEST['ORDER_CURRENCY'])) ? $_REQUEST['ORDER_CURRENCY'] : 'HUF';
	
		
	/**
	 * Start IDN
	 */		
	$idn = new SimpleIdn($config, $orderCurrency);

	
	/**
	 * Set needed fields
	 */	
	$data['REFNOEXT'] = (isset($_REQUEST['order_ref'])) ? $_REQUEST['order_ref'] : 'N/A';
	$data['ORDER_REF'] = (isset($_REQUEST['payrefno'])) ? $_REQUEST['payrefno'] : 'N/A';
	$data['ORDER_AMOUNT'] = (isset($_REQUEST['ORDER_AMOUNT'])) ? $_REQUEST['ORDER_AMOUNT'] : 'N/A';	
	$data['ORDER_CURRENCY'] = $orderCurrency;
	$data['IDN_DATE'] = @date("Y-m-d H:i:s");
	$response = $idn->requestIdn($data);


	/**
	 * Check response
	 */	
	if (isset($response['RESPONSE_CODE'])) {	
		if($idn->checkResponseHash($response)){
			/*
			* your code here
			*/
			
			/*			
			print "<pre>";	
			print_r($response);
			print "</pre>";
			*/		
		}
	}
  
	$idn->errorLogger();
  
	$message = ORDER_ID.': <b>'. $response['ORDER_REF'] . '</b><br/>';
	$message .= RESPONSECODE.': <b>'. $response['RESPONSE_CODE'] . '</b><br/>';
	$message .= RESPONSEMSG.': <b>'. $response['RESPONSE_MSG'] . '</b><br/>';
	$message .= DATE.': <b>'. $response['IDN_DATE'].'</b><br/>';
						
	$response['PAYREFNO'] = $response['ORDER_REF'];
	$response['REFNOEXT'] = $data['REFNOEXT'];
?>

<!--

	All of following code for test purpose only. 

-->	
<?php 
$mydata = Array(
'type'=>'idn',
'title'=>'IDN',
'message'=>$message,
'data'=>$response
);
include 'demo/template.php' ; ?>