<?php
 
$config = array(
	//HUF
	'HUF_MERCHANT' => "",			//merchant account ID (HUF)
    'HUF_SECRET_KEY' => "",			//secret key for account ID (HUF)
	//EUR
    'EUR_MERCHANT' => "S146906",			//merchant account ID (EUR)
    'EUR_SECRET_KEY' => "3vBvvaBiD1DyL9B90iv34mVW4l2i7k4A",			//secret key for account ID (EUR)
	//USD
    'USD_MERCHANT' => "",			//merchant account ID (USD)
    'USD_SECRET_KEY' => "",			//secret key for account ID (USD)
	//PLN
	'PLN_MERCHANT' => "",			//merchant account ID (PLN)
    'PLN_SECRET_KEY' => "",			//secret key for account ID (PLN)
	//CZK
	'CZK_MERCHANT' => "",			//merchant account ID (CZK)
    'CZK_SECRET_KEY' => "",			//secret key for account ID (CZK)
	//HRK
	'HRK_MERCHANT' => "",			//merchant account ID (HRK)
    'HRK_SECRET_KEY' => "",			//secret key for account ID (HRK)
	//RSD
	'RSD_MERCHANT' => "",			//merchant account ID (RSD)
    'RSD_SECRET_KEY' => "",			//secret key for account ID (RSD)
	//BGN
	'BGN_MERCHANT' => "",			//merchant account ID (BGN)
    'BGN_SECRET_KEY' => "",			//secret key for account ID (BGN)
	//RON
	'RON_MERCHANT' => "",			//merchant account ID (RON)
    'RON_SECRET_KEY' => "",			//secret key for account ID (RON)
	//GBP
	'GBP_MERCHANT' => "",			//merchant account ID (GBP)
    'GBP_SECRET_KEY' => "",			//secret key for account ID (GBP)
	
	'CURL' => true,					//use cURL or not
    'SANDBOX' => true,				//true: sandbox transaction, false: live transaction
	'PROTOCOL' => 'https',			//http or https
	
    'BACK_REF' => $_SERVER['HTTP_HOST'] . '/v1/rester/backref',		   //url of payment backref page
    'TIMEOUT_URL' => $_SERVER['HTTP_HOST'] . '/v1/rester/timeout',     //url of payment timeout page
    'IRN_BACK_URL' => $_SERVER['HTTP_HOST'] . '/v1/rester/irn',        //url of payment irn page
    'IDN_BACK_URL' => $_SERVER['HTTP_HOST'] . '/v1/rester/idn',        //url of payment idn page
    'IOS_BACK_URL' => $_SERVER['HTTP_HOST'] . '/v1/rester/ios',        //url of payment idn page
	
    'GET_DATA' => $_GET,
    'POST_DATA' => $_POST,
    'SERVER_DATA' => $_SERVER,    
	
	'LOGGER' => true,                                   //basic transaction log
    'LOG_PATH' => 'log',  								//path of log file
	
	'DEBUG_LIVEUPDATE_PAGE' => false,					//Debug message on demo LiveUpdate page (only for development purpose)
	'DEBUG_LIVEUPDATE' => false,						//LiveUpdate debug into log file
	'DEBUG_BACKREF' => false,							//BackRef debug into log file
	'DEBUG_IPN' => false,								//IPN debug into log file
	'DEBUG_IRN' => false,								//IRN debug into log file
	'DEBUG_IDN' => false,								//IDN debug into log file
	'DEBUG_IOS' => false,								//IOS debug into log file
	'DEBUG_ONECLICK' => false,							//OneClick debug into log file
	'DEBUG_ALU' => false,								//ALU debug into log file
);


?>
