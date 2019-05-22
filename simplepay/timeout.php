<?php
	/*
	 * Import config data
	 */		
	require_once("sdk/config.php");

	/*
	 * Test helper functions  -- ONLY FOR TEST!
	 */
	require_once('demo/demo_functions.php');
	require_once 'sdk/SimplePayment.class.php';

	$timeOut = new SimpleLiveUpdate($config);
	
	if (@$_REQUEST['redirect'] == 1) {
		$message = '<b><font color="red">' . ABORTED_TRANSACTION . '</font></b><br/>';
		$log['TRANSACTION'] = 'ABORT';
	} else {
		$message = '<b><font color="red">' . TIMEOUT_TRANSACTION . '</font></b><br/>';
		$log['TRANSACTION'] = 'TIMEOUT';
	}
	
	$message .= TIMEOUT_NOTICE . '<br/><br/>';
	$message .= DATE . ': <b>' . date('Y-m-d H:i:s', time()) . '</b><br/>';
	$message .= ORDER_ID . ': <b>' . $_REQUEST['order_ref'] . '</b><br/>';
	$log['ORDER_ID'] = (isset($_REQUEST['order_ref'])) ? $_REQUEST['order_ref'] : 'N/A';
	$log['CURRENCY'] = (isset($_REQUEST['order_currency'])) ? $_REQUEST['order_currency'] : 'N/A';
	$log['REDIRECT'] = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : '0';
	$timeOut->logFunc("Timeout", $log, $log['ORDER_ID']); 
	$timeOut->errorLogger(); 
			 
?>

<!--

	All of following code for test purpose only. 

-->

<?php 
	/*
	*	template handling
	*/
		$mydata = Array(
			'type' => 'timeout',
			'title' => 'Timeout',
			'message' => $message,
			'data' => array()
		);

		require_once 'demo/template.php'; 
	/*
	*	template handling end
	*/	
?>
