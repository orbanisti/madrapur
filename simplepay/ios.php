<?php

	/**
	 * Optional error riporting
	 */
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	/**
	 * Import config data
	 */
	require_once("sdk/config.php");

	/**
	 * Import PayUPayment class
	 */
	require_once('sdk/SimplePayment.class.php');

	/**
	 * Test helper functions  -- ONLY FOR TEST!
	 */
	require_once 'demo/demo_functions.php';
	
	/**
	 * Set merchant account data by currency
	 */
	$orderCurrency = (isset($_REQUEST['ORDER_CURRENCY'])) ? $_REQUEST['ORDER_CURRENCY'] : 'HUF';

	/**
	 * Set transaction external reference ID
	 */
	$orderexternalId = (isset($_REQUEST['order_ref'])) ? $_REQUEST['order_ref'] : 'N/A';
	
	//IOS
	$ios = new SimpleIos($config, $orderCurrency, $orderexternalId);
	
	$ios->errorLogger(); 
	
	$message = DATE . ':<b>' . @$ios->status['ORDER_DATE'].'</b><br/>';	
	$message .= PAYREFNO . ':<b>' . @$ios->status['REFNO'].'</b><br/>';	
	$message .= ORDER_ID . ':<b>' . @$ios->status['REFNOEXT'].'</b><br/>';	
	$message .= STATUS . ':<b>' . @$ios->status['ORDER_STATUS'].'</b><br/>';	
	$message .= PAYMENT_METHOD . ':<b>' . @$ios->status['PAYMETHOD'].'</b><br/>';	
	
	/*
	*	template handling
	*/						
	$mydata = Array(
		'type' => 'ios',
		'title' => 'IOS - Instant Order Status',
		'message' => $message,
		'data' => array()
	);
	
	require_once 'demo/template.php'; 
	/*
	*	template handling end
	*/	
?>