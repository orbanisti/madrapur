<?php

	date_default_timezone_set('Europe/Budapest');

	$handle = fopen($config['LOG_PATH'] . '/' . date('Ymd') . '.log', "r");
	$outarray=Array();
	$tipusgyujto = $blokkok = Array();	
	$valto = '';
	$blokkszamlalo = 0;	
	$orderref= isset($_GET['order_ref']) ? $_GET['order_ref'] : '';

	if($orderref !=""){		
		if ($handle) {			
			while (($line = fgets($handle)) !== false) {
		 
				$egysor = explode(" ",$line);					
				if(isset($egysor[4]) and strstr($egysor[4], 'ITEM_') ) {					
					$ujegysor2 = explode("=", $line);
					$ujegysor = explode(": ", $ujegysor2[1]);					
					if(isset($ujegysor[0]) and isset($ujegysor[1])){
						$egysor[4] = $ujegysor[0] . '=' . $ujegysor[1];
					} else {	
						$egysor[4] ='empty=empty';
					}					
				} 
			
				if($egysor[0] == $orderref) {					
					if($egysor[1] != $valto and $valto != "") {
						$valto = $egysor[1];
						$blokkszamlalo++;
					}else{
						$valto = $egysor[1];
					}
					$blokkok[$valto . '-' . $blokkszamlalo]['data'][] = $egysor[4];
					$blokkok[$valto . '-' . $blokkszamlalo]['date'] = $egysor[2] . ' ' . $egysor[3];				
				}			
			}
		fclose($handle);
		
		}
	}else{
		echo NO_ORDERREF_TEXT;
	}

?>

 <script type="text/javascript">
  
	$(document).ready(function(){
		$('.headtr').click(function(){
	  
			var openid = $(this).attr('rel');
			$('.tartalom_'+openid).toggle();
			$('.glyphicon_'+openid).html('-');
	  
	  
		});
	});
 </script>
 
<style type="text/css">.headtr:hover{cursor:pointer;}</style>
  
<div class="row clearfix">
	<div class="col-md-12 column">
			
	<h1><?php echo TRX_LOG_BTN; ?></h1>	
	
	<?php
	
		$tipusszamlalo = 1;
		$logHtml = '';
	
		foreach($blokkok as $rqk => $rqv)
		{
												
			$firstkey0 = explode("-", $rqk);												
			$firstkey = explode("_", $firstkey0[0]);												
			$firstkey1 = isset($firstkey[0]) ? $firstkey[0] : $rqk;												
			$secondkey = isset($firstkey[1]) ? $firstkey[1] : "";
												
			$logHtml .= '<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title headtr tipus_' . $rqk . '" rel="' . $rqk . '">
								<strong>'.$tipusszamlalo . '. ' . $firstkey1 . ' ' . $secondkey . '&nbsp;&nbsp;&nbsp;' . $rqv['date'] . '</strong>
								<i class="glyphicon glyphicon_' . $rqk . '" style="float:right;">+</i>
								</h3>
							</div>
							<div class="panel-body">
								<table class="table table-striped tartalom_' . $rqk . '" style="display:none;">
									<thead>
										<tr>
											<th>#</th>
											<th>' . LOGTEXT1 . '</th>
											<th>' . LOGTEXT2 . '</th>
											<th>' . LOGTEXT3 . '</th>
											<th>' . LOGTEXT4 . '</th>
											<th>' . LOGTEXT5 . '</th>
										</tr>
									</thead>
									<tbody>';
												 
									foreach($rqv['data'] as $logLineKey => $logLineVal) {													
										$variable = explode("=", $logLineVal);											
										$logHtml .= '<tr>													
														<td>' . ($logLineKey+1) . '</td>
														<td>' . $orderref . '</td>
														<td>' . $firstkey1 .' '.$secondkey . '</td>
														<td>' . $rqv['date'] . '</td>
														<td>' . $variable[0] . '</td>
														<td>' . $variable[1] . '</td>
													</tr>';
												}
										$logHtml .= '</tbody>
										</table>
							</div>
						</div>';
			$tipusszamlalo ++;
		} //foreach end	

	print $logHtml;	
?>
	</div>
</div>

<div class="row clearfix">
	<div class="col-md-4 column"></div>
		
	<div class="col-md-4 column">
		<p>
		<?php 
			if($mydata['type'] != "liveupdate")
			{
		?>
			<a href="index.php" type="submit" class="btn btn-lg btn-danger"><?php echo NEW_TEST_PAYMENT_BTN;?></a>
		<?php 
			} 
		?>					
		</p>
	</div>
		
	<div class="col-md-4 column"></div>
</div>