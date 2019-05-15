<?php require_once('tpl_header.php');?>


<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			
			<div class="row clearfix">
				<div class="col-md-8 column">

					<div class="tab-content">
						<?php echo $mydata['message'];?><br/><br/>	
					</div>
					
				</div>
				
				<div class="col-md-4 column">
				
				</div>
			</div>
		</div>
	</div>
	<?php 
		 require_once('templates/' . $mydata['type'] . '.php');
		 require_once('templates/backref.php');
	?>

	<?php if($mydata['type'] != "liveupdate"){
		require_once('templates/log.php'); 
	}?>
				 
	 
<?php require_once('tpl_footer.php');?>