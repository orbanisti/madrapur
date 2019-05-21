<?php
	require_once OTP.'sdk/config.php';
	require_once OTP.'sdk/SimplePayment.class.php';
	
	$orderCurrency = (isset($_REQUEST['CURRENCY'])) ? $_REQUEST['CURRENCY'] : 'N/A';

	$ipn = new SimpleIpn($config, $orderCurrency);
	if($ipn->validateReceived()){
		$ipn->confirmReceived();
	}
	$ipn->errorLogger();

    if ($ipn->debug) {
        return ["debug"];
    }
    if (count($ipn->errorMessage) > 0) {
        return ["error"];
    }

    return true;


