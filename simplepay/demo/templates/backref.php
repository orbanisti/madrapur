<div class="row clearfix">
	<div class="col-md-4 column">
		<?php 
			if (isset($backStatus['RESULT']) && $backStatus['RESULT']) {
			    $orderRef = $_REQUEST['order_ref'];
		?>
			<h2><?php echo IRN_TEXT3;?></h2>
				
			<p><?php echo IRN_TEXT;?></p>
			
			<p><?php echo sprintf(IRN_TEXT2, $backStatus['PAYREFNO']);?></p>
			
			<form method="get" action="<?php echo $config['PROTOCOL'] . '://' . $config['IRN_BACK_URL']; ?>">
				<input type="hidden" name="order_ref" id="order_ref" value="<?php echo $orderRef;?>">
				<input type="hidden" name="payrefno" id="payrefno" value="<?php echo $_REQUEST['payrefno'];?>">				
				<input type="hidden" name="ORDER_AMOUNT" id="ORDER_AMOUNT" value="1207">
				<input type="hidden" name="AMOUNT" id="AMOUNT" value="1207">
				<input type="hidden" name="ORDER_CURRENCY" id="ORDER_CURRENCY" value="<?php echo $orderCurrency; ?>">	
				<button type="submit" class="btn btn-lg btn-success"><?php echo IRN_TEXT3 . ' ' . RUN_TEXT;?></button>	
			</form>		
		<?php
			}
		?>				
	</div>
			
	<div class="col-md-4 column">
		<?php 
			if (isset($backStatus['RESULT']) && $backStatus['RESULT']) {
                $orderRef = $_REQUEST['order_ref'];
		?>
				
		<h2><?php echo IDN_TEXT3;?></h2>
				
		<p><?php echo sprintf(IDN_TEXT2, $backStatus['PAYREFNO']);?></p>
		
		<form method="get" action="<?php echo $config['PROTOCOL'] . '://' . $config['IDN_BACK_URL']; ?>">
			<input type="hidden" name="order_ref" id="order_ref" value="<?= $orderRef ?>">
			<input type="hidden" name="payrefno" id="payrefno" value="<?php echo $_REQUEST['payrefno'];?>">
			<input type="hidden" name="ORDER_AMOUNT" id="ORDER_AMOUNT" value="1207">
			<input type="hidden" name="ORDER_CURRENCY" id="ORDER_CURRENCY" value="<?php echo $orderCurrency; ?>">
			<button type="submit" class="btn btn-lg btn-success"><?php echo IDN_TEXT3 . ' ' . RUN_TEXT;?></button>	
		</form>	
		<?php
			}
		?>
	</div>
			
	<div class="col-md-4 column">
		<?php 
			if($mydata['type'] != "ios" and $mydata['type'] != "liveupdate" and $mydata['type'] != "timeout" and isset($_REQUEST['payrefno']))
			{
		?>	
					
		<h2><?php echo IOS_TEXT3;?></h2>
		
		<p><?php echo IOS_TEXT;?></p>
		
		<p><?php echo sprintf(IOS_TEXT2,$_REQUEST['payrefno']);?></p>
		
			<form method="GET" action="<?php echo $config['PROTOCOL'] . '://' . $config['IOS_BACK_URL']; ?>">
				<input type="hidden" name="simpleid" id="simpleid" value="<?php echo $_REQUEST['payrefno'];?>">
				<input type="hidden" name="order_ref" id="order_ref" value="<?php echo $_REQUEST['order_ref'];?>">
				<input type="hidden" name="ORDER_CURRENCY" id="ORDER_CURRENCY" value="<?php echo $orderCurrency; ?>">	
				<button type="submit" class="btn btn-lg btn-success"><?php echo IOS_TEXT3 . ' ' . RUN_TEXT;?></button>	
			</form>		
		<?php 
			} 
		?>
	</div>
</div>
		
<hr>
	
<div class="row clearfix">
	<div class="col-md-4 column">&nbsp;</div>
	<div class="col-md-4 column">
		<p>
			<?php 
				if($mydata['type']!="liveupdate")
				{
			?>
			<a href="index.php" type="submit" class="btn btn-lg btn-danger"><?php echo NEW_TEST_PAYMENT_BTN;?></a>
			<?php 
				}
			?>						 
		</p>
	</div>
	<div class="col-md-4 column">&nbsp;</div>
</div>
	 