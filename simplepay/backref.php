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
		if($backref->order_ref != ""){
			$handle = fopen(OTP.$config['LOG_PATH'] . '/' . @date('Ymd') . '.log', "c");
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
		}
		
		// Notification by payment method		
		//CCVISAMC
		if ($backStatus['PAYMETHOD'] == 'Visa/MasterCard/Eurocard') {
			$message .= 'SUCCESSFUL_CARD_AUTHORIZATION';
			if ($backStatus['ORDER_STATUS'] == 'IN_PROGRESS') {
				$message .= 'WAITING_FOR_IPN;';
			} elseif ($backStatus['ORDER_STATUS' ] == 'PAYMENT_AUTHORIZED') {
				$message .= 'WAITING_FOR_IPN;';
			} elseif ($backStatus['ORDER_STATUS'] == 'COMPLETE') {
				$completeMessage = 'WAITING_FOR_IPN;';
				if ($ipnInLog) {
					$completeMessage = 'CONFIRMED_IPN;';
				}
				$message .= $completeMessage;			
			}
		}
		//WIRE
		elseif ($backStatus['PAYMETHOD'] == 'Bank/Wire transfer') {
			$message = '<b>wire' . SUCCESSFUL_WIRE . '</b><br/>';
			if ($backStatus['ORDER_STATUS'] == 'PAYMENT_AUTHORIZED' || $backStatus['ORDER_STATUS'] == 'COMPLETE') {
				$message .= '<b>waut' . CONFIRMED_WIRE . '</b><br/>';
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

		$message = '<b>' . UNSUCCESSFUL_TRANSACTION . '</b><br/>';
		$message .= '<b>' . END_OF_TRANSACTION . '</b><br/>';
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
		$message .= '<b>ERROR: </b>  ' . $_REQUEST['err'] . '<br/>'; 
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

		require_once OTP.'demo/template.php';

        $qString = $_SERVER['QUERY_STRING'];
        $prettyString = "";

        $qStringArray = explode("&", $qString);

        foreach ($qStringArray as $element) {
            $elementString = explode("=", $element);

            $prettyString .= "/" . $elementString[1];
        }

        return true;
		redirect("https://budapestrivercruise.co.uk/checkout/thankyou" . $prettyString);
	/*
	*	template handling end
	*/	
?>
			
