<?php
	
		$started = false;
		
		if (isset($_REQUEST['testmethod'])) {
			$buttontype = 'auto';
			if ($lu->debug_liveupdate_page) {
				$buttontype = 'button';
			} 			
			if(!isset($lu->fieldData['PAY_METHOD'])) {
				$lu->setField("PAY_METHOD", "CCVISAMC");
			}
			
			switch ($_REQUEST['testmethod']) {
				case 'CCVISAMC':
					$lu->setField("PAY_METHOD", "CCVISAMC");					
					$started = true;
					$display = $lu->createHtmlForm('SimplePayForm', $buttontype, PAYMENT_BUTTON);					
				break;
				case 'WIRE':
					$lu->setField("PAY_METHOD", "WIRE");					
					$started = true;
					$display = $lu->createHtmlForm('SimplePayForm', $buttontype, PAYMENT_BUTTON);	
				break;						
			}			
			$lu->errorLogger(); 
			
			if ($lu->debug_liveupdate_page && count($lu->errorMessage) == 0) {
			    print "<pre>";
			    print $lu->getDebugMessage();
			    print "</pre>";
			   
			}
			if (count($lu->errorMessage) > 0) {
			    print "<pre>";
			    print $lu->getErrorMessage();
			    print "</pre>";
			   
			}
		}
			
		if ($started) {
?>

<div class="container">
	<div class="row clearfix">&nbsp;</div>
			
	<div class="row clearfix">
		<div class="col-md-4 column">&nbsp;</div>
		<div class="col-md-4 column">
			<img src="demo/img/simplepay_logo_360.png">
				<h2><?php 
					if (!$lu->debug_liveupdate_page) {
						echo TRANSACTION_STARTED . "<br>"; 
						echo "<h3>" . PLEASE_WAIT . "</h3>";
					} elseif ($lu->debug_liveupdate_page) {
						echo TRANSACTION_ABORTED;
					}					
					?></h2>			
				<p>
					<br>
						<?php 
							if (!$lu->debug_liveupdate_page) {
								echo WILL_BE_REDIRECTED; 
							} elseif ($lu->debug_liveupdate_page) {
								echo ABORT_DESC_1 . "<br>";
								echo ABORT_DESC_2;
							}						
						?><br><br>
						<?php 
							if (!$lu->debug_liveupdate_page) {
								echo NO_REDIRECT_NOTICE;
							} elseif ($lu->debug_liveupdate_page) {
								echo DO_REDIRECT_NOTICE;
							}
						?><br><br>
						<?php 
							if (!$lu->debug_liveupdate_page) {
								echo THANK_YOU;
							}	
						?>
				</p>
				<p><?php echo $display; ?></p>
		</div>
		<div class="col-md-4 column">&nbsp;</div>
	</div>
</div>
	
	<?php
			if ($lu->debug_liveupdate_page) {
				exit;
			}
		}
	?>
	
<div class="row clearfix">
	<div class="col-ld-12 col-md-12 column">
		<div class="tabbable" id="tabs-619794">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#panel-80858" data-toggle="tab"><?php echo METHOD_CCVISAMC; ?></a>
				</li>
				<li>
					<a href="#panel-684516" data-toggle="tab"><?php echo METHOD_WIRE; ?></a>
				</li>								
			</ul>
		</div>
		
		<div class="tab-content">
			<div class="tab-pane active" id="panel-80858">
				<br>
				
				<p>
					<b><?php echo METHOD_CCVISAMC." ".TEST; ?></b>
				</p>
				
				<p>
					<?php echo CALL_TO_START_TRANSACTION; ?><br><br>
					<?php echo METHOD_CCVISAMC_DESC; ?>
				</p>
								
				<p>						
					<b><?php echo START_CCVISAMC; ?></b>
				</p>	
			
				<div class="row clearfix">
					<div class="col-md-4 column">
						<?php
							$configCurrencies = array('HUF', 'EUR', 'USD', 'PLN', 'CZK', 'HRK', 'RSD', 'BGN', 'RON', 'GBP');
							$paymentPageLanguages = array('HU', 'EN', 'DE', 'SK', 'RO', 'CZ', 'HR', 'IT', 'PL', 'ES');

							$options = '';
							$optionsCounter = 0;
							foreach ($configCurrencies as $configCurrency) {
								if (isset($config[$configCurrency . '_MERCHANT']) && $config[$configCurrency . '_MERCHANT'] != '') {
									$options .= '<option value="' . $configCurrency . '">' . $configCurrency . '</option>';
									$optionsCurrency = $configCurrency;
									$optionsCounter++;
								}								
							}

							if ($options != '') {
						?>

							<form method="POST" action="<?php print "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>">
								<input type="hidden" name="testmethod" id="testmethod" value="CCVISAMC">

								<div>
								<label for="testlanguage"><?php echo PAYMENT_PAGE_LANGUAGE; ?></label>
								<select name="testlanguage" id="testlanguage" class="form-control" required="">
									<option value="HU">Magyar (HU)</option>
									<option value="EN">English (EN)</option>
									<option value="DE">Deutsch (DE)</option>
									<option value="SK">Slovenčina (SK)</option>
									<option value="RO">Română (RO)</option>
									<option value="CZ">Čeština (CZ)</option>
									<option value="HR">Hrvatski (HR)</option>
									<option value="IT">Italiano (IT)</option>
									<option value="PL">Polski (PL)</option>
									<option value="ES">Español (ES)</option>
								</select>
								</div>
								<br/>

								<?php
									if ($optionsCounter == 1) {
								?>
										<div>
											<input type="hidden" name="testcurrency" id="testcurrency" value="<?php print $optionsCurrency; ?>">
										</div>
										
										<div>
										<br/>
											<button type="submit" class="btn btn-lg btn-success"><?php echo $optionsCurrency . ' ' . PAYMETN_BTN;?></button>	
										</div>										
								<?php		
									}
									elseif ($optionsCounter > 1) {
								?>
										<div>
											<label for="testcurrency"><?php echo PAYMENT_CURRENCY; ?></label>  
											<select name="testcurrency" class="form-control" required="">										
											<?php print $options; ?>								
											</select>
										</div>
										<div>
										<br/>
										<button type="submit" class="btn btn-lg btn-success"><?php echo ucfirst(PAYMETN_BTN);?></button>
										</div>
								<?php		
									}
								?>										

							</form><br>
							
						<?php
							}
						?>
													
					</div>
				
                </div>
					<?php
						if ($optionsCounter == 0) 
						{
					?>									
					<p>
						<?php echo MISSING_PARAMS;?>
					</p>							
					<?php
						}
					?>
			</div>
                           
			<div class="tab-pane" id="panel-684516">
				<br>
				
				<p>
					<b><?php echo METHOD_WIRE . " " . TEST; ?></b>
				</p>
								
				<p>
					<?php echo CALL_TO_START_TRANSACTION; ?><br><br>
					<?php echo METHOD_WIRE_DESC; ?>
				</p>	
				<?php
					if (!isset($config['HUF_MERCHANT']) || $config['HUF_MERCHANT'] == '')
					{
				?>									
				<p>
					<?php echo MISSING_PARAMS_WIRE;?>
				</p>							
				<?php
					}
					else
					{
				?>								
				<p>
					<form method="POST" action="<?php print "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']; ?>">
						<input type="hidden" name="testmethod" id="testmethod" value="WIRE">
						<button type="submit" class="btn btn-lg btn-success"><?php echo START_WIRE; ?></button>	
					</form>
				</p>
				<?php
					}
				?>

			</div>                           									
		</div>				
	</div>		
</div>