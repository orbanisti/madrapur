<?php
	/**
	 * Import config data
	 */		
	require_once 'sdk/config.php';
	
	/**
	 * Import SimplePayment class
	 */		
	require_once 'sdk/SimplePayment.class.php';
	
	/**
	 * Test helper functions  -- ONLY FOR TEST!
	 */
	require_once 'demo/demo_functions.php';

	/**
	 * Set merchant account data by currency
	 */		
 	
	$orderCurrency = (isset($_REQUEST['order_currency'])) ? $_REQUEST['order_currency'] : 'N/A';
	 				
	/**
	 * Start backref
	 */		
	$backref = new SimpleBackRef($config, $orderCurrency );
   
	/**
	 * Add order reference number from merchant system (ORDER_REF)
	 */			
	$backref->order_ref = (isset($_REQUEST['order_ref'])) ? $_REQUEST['order_ref'] : 'N/A';
	
	$message = '';
	
	if(isset($_REQUEST['err'])){
		$backref->logFunc("BackRef", $_REQUEST, $_REQUEST['order_ref']); 
		
	/**
	 * Check backref
	 */			
	} elseif ($backref->checkResponse()){
				
		/**
		 * SUCCESSFUL card authorizing
		 * Notify user and wait for IPN
		 * Need to notify user
		 * 
		 */
		$backStatus = $backref->backStatusArray;

		// Check log if IPN message was received
		$ipnInLog = false;
		/*if($backref->order_ref != ""){
			$handle = fopen(OTP.$config['LOG_PATH'] . '/' . @date('Ymd') . '.log', "r");
			if ($handle) {			
				while (($line = fgets($handle)) !== false) {	 
					$logRow = explode(" ", $line);
					if (isset($logRow)) {
						if ($logRow[0] == $backref->order_ref && $logRow[1] == 'IPN') {
							if (isset($logRow[4])) {
								if (strstr($logRow[4], "COMPLETE")) {
									$ipnInLog = true;
								}							
							}
						}				
					}
				}
			}
		}*/
		
		// Notification by payment method		
		//CCVISAMC
		if ($backStatus['PAYMETHOD'] == 'Visa/MasterCard/Eurocard') {
			$message .= '<b><font color="green">' . SUCCESSFUL_CARD_AUTHORIZATION . '</font></b><br/>';
			if ($backStatus['ORDER_STATUS'] == 'IN_PROGRESS') {
				$message .= '<b><font color="green">' . WAITING_FOR_IPN . '</font></b><br/>';
			} elseif ($backStatus['ORDER_STATUS' ] == 'PAYMENT_AUTHORIZED') {
				$message .= '<b><font color="green">' . WAITING_FOR_IPN . '</font></b><br/>';
			} elseif ($backStatus['ORDER_STATUS'] == 'COMPLETE') {
				$completeMessage = '<b><font color="green">' . WAITING_FOR_IPN . '</font></b><br/>';
				if ($ipnInLog) {
					$completeMessage = '<b><font color="green">'. CONFIRMED_IPN .'</font></b><br/>';
				}
				$message .= $completeMessage;			
			}
		}
		//WIRE
		elseif ($backStatus['PAYMETHOD'] == 'Bank/Wire transfer') {
			$message = '<b><font color="green">' . SUCCESSFUL_WIRE . '</font></b><br/>';
			if ($backStatus['ORDER_STATUS'] == 'PAYMENT_AUTHORIZED' || $backStatus['ORDER_STATUS'] == 'COMPLETE') {
				$message .= '<b><font color="green">' . CONFIRMED_WIRE . '</font></b><br/>';
			} 			
		}
		
		/**
		 * Your code here
		 */	
		 
			
	} else {
		
		/**
		 * UNSUCCESSFUL card authorizing
		 * END of transaction
		 * Need to notify user
		 * 
		 */
		$backStatus = $backref->backStatusArray;	

		$message = '<b><font color="red">' . UNSUCCESSFUL_TRANSACTION . '</font></b><br/>';
		$message .= '<b><font color="red">' . END_OF_TRANSACTION . '</font></b><br/>';
		$message .= UNSUCCESSFUL_NOTICE . '<br/><br/>';

		/**
		 * Your code here
		 */	
		 
	}
	$backref->errorLogger(); 

	/**
	 * Notification
	 */	
	if(!isset($_REQUEST['err'])){
		$message .= PAYREFNO . ': <b>' . $backStatus['PAYREFNO'] . '</b><br/>'; 
		$message .= ORDER_ID . ': <b>' . $backStatus['REFNOEXT'] . '</b><br/>';
		$message .= BACKREF_DATE . ': <b>' . $backStatus['BACKREF_DATE'] . '</b><br/>';
	} 
	
	if (isset($_REQUEST['err'])) {
		$message .= '<hr>';
		$message .= '<b><font color="red">ERROR: </font></b>  ' . $_REQUEST['err'] . '<br/>'; 
	}
	
?>

<!--

	All of following code for test purpose only. 

-->

<?php 
	/*
	*	template handling
	*/
		$mydata = Array(
			'type' => 'backref',
			'title' => 'Backref',
			'message' => (isset($message)) ? $message : "N/A",
			'data' => (isset($backStatus)) ? $backStatus : "N/A",
		);

		// require_once OTP.'demo/template.php';

		redirect("https://budapestrivercruise.co.uk/checkout/thankyou?" . $_SERVER['QUERY_STRING']);
	/*
	*	template handling end
	*/	
?>
			
