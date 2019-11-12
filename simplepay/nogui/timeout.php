<?php
	require_once(OTP."sdk/config.php");
	require_once OTP.'sdk/SimplePayment.class.php';

	$orderCurrency = (isset($_REQUEST['order_currency'])) ? $_REQUEST['order_currency'] : 'N/A';
	$orderRef = (isset($_REQUEST['order_ref'])) ? $_REQUEST['order_ref'] : 'N/A'; 
	
	$timeOut = new SimpleLiveUpdate($config, $orderCurrency);
	$timeOut->commMethod = 'timeout';
	$timeOut->order_ref = $orderRef;
	
	$message = "";
	if (@$_REQUEST['redirect'] == 1) {
		$message = '<b><font color="red">ABORTED TRANSACTION</font></b><br/>';
		$log['TRANSACTION'] = 'ABORT';
	} else {
		$message = '<b><font color="red">TIMEOUT TRANSACTION</font></b><br/>';
		$log['TRANSACTION'] = 'TIMEOUT';
	} 
	
	$message .= 'DATE: <b>' . date('Y-m-d H:i:s', time()) . '</b><br/>';
	$message .= 'ORDER ID: <b>' . $_REQUEST['order_ref'] . '</b><br/>';
	
	$log['ORDER_ID'] = $orderRef;
	$log['CURRENCY'] = $orderCurrency;
	$log['REDIRECT'] = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '0';
	$timeOut->logFunc("Timeout", $log, $log['ORDER_ID']); 
	$timeOut->errorLogger(); 
	
	echo $message;			 
?>

