<?php
 
 	/**
	 * Optional error riporting
	 */	 
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
		
	/**
	 * Import config data
	 */		
	require_once 'sdk/config.php';

	/**
	 * Import SimplePayment class
	 */
	require_once 'sdk/SimplePayment.class.php';
	
	/**
	 * Set merchant account data by currency
	 */		
	 
	$orderCurrency = (isset($_REQUEST['CURRENCY'])) ? $_REQUEST['CURRENCY'] : 'N/A';
	 
	/**
	 * Start IPN
	 */
	$ipn = new SimpleIpn($config, $orderCurrency);
   	
	/**
	 * IPN successful
	 * This is the real end of successful payment
	 */		
	if($ipn->validateReceived()){	
    	/**
		 * End of payment: SUCCESSFUL
         * echo <EPAYMENT> (must have)
		 */
		$ipn->confirmReceived();
		               		 
		/**
		 * Your code here
		 */
         /*
		 print "<pre>";	 
         print_r($_REQUEST);         
		 print "</pre>";
        */		 
	}

		
    /**
     * Error and debug info
     */  
	$ipn->errorLogger(); 	
	
	/*
    if ($ipn->debug) {
		foreach ($ipn->debugMessage as $debug) {
			print $debug . "\n";
		}
    }
    if (count($ipn->errorMessage) > 0) {
		foreach ($ipn->debugMessage as $debug) {
			print $debug . "\n";
		}
		foreach ($ipn->errorMessage as $error) {
			print $error . "\n";
		}		
    }
	*/
    
?>


