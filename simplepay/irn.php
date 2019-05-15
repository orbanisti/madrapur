<?php

 	/**
	 * Optional error riporting
	 */	  
	error_reporting(E_ALL|E_STRICT);
	ini_set('display_errors', '1');

	 /*
	 * Import config data
	 */		
	require_once("sdk/config.php");

	/*
	 * Import SimplePaymentExtra class
	 */
	require_once('sdk/SimplePayment.class.php');

	/*
	 * Test helper functions  -- ONLY FOR TEST!
	 */
	require_once('demo/demo_functions.php');

	/**
	 * Set merchant account data by currency
	 */		
	
	$orderCurrency = (isset($_REQUEST['ORDER_CURRENCY'])) ? $_REQUEST['ORDER_CURRENCY'] : 'HUF';
		
	/**
	 * Start IRN
	 */	
	$irn = new SimpleIrn($config, $orderCurrency);

	
	/**
	 * Set needed fields
	 */		
	$data['REFNOEXT']  = isset($_REQUEST['order_ref']) ? $_REQUEST['order_ref'] : 'N/A';
	$data['ORDER_REF'] = isset($_REQUEST['payrefno']) ? $_REQUEST['payrefno'] : 'N/A';
	$data['ORDER_AMOUNT'] =  isset($_REQUEST['ORDER_AMOUNT']) ? $_REQUEST['ORDER_AMOUNT'] : 'N/A';	
	$data['ORDER_CURRENCY'] = $orderCurrency;
	$data['IRN_DATE'] = @date("Y-m-d H:i:s");
	$data['AMOUNT'] =  isset($_REQUEST['AMOUNT']) ? $_REQUEST['AMOUNT'] : 'N/A';
	$response = $irn->requestIrn($data);


	/**
	 * Check response
	 */			
	if (isset($response['RESPONSE_CODE'])) {
		if($irn->checkResponseHash($response)) {
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
	 
	$irn->errorLogger();  
	
	$message = PAYREFNO.': <b>' . $response['ORDER_REF'] . '</b><br/>';
	$message .= RESPONSECODE.': <b>' . $response['RESPONSE_CODE'] . '</b><br/>';
	$message .= RESPONSEMSG.': <b>' . $response['RESPONSE_MSG'] . '</b><br/>';
	$message .= DATE.': <b>' . $response['IRN_DATE'] . '</b><br/>';
						
	$response['PAYREFNO'] = $response['ORDER_REF'];	
	$response['REFNOEXT'] = $data['REFNOEXT'];	
				
	$message .= sprintf(IRNTEXTTPL, $response['ORDER_REF']);
?>

<!--

	All of following code for test purpose only. 

-->
<?php 
	/*
	*	template handling
	*/
		$mydata = Array(
			'type' => 'irn',
			'title' => 'IRN - Instant Refund Notification',
			'message' => $message,
			'data' => $response
		);
		
		require_once 'demo/template.php'; 
	/*
	*	template handling end
	*/	
?>