<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>SimplePay PHP SDK</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="demo/css/bootstrap.min.css" rel="stylesheet">
	<link href="demo/css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
    <link type="image/x-icon" rel="icon" href="https://www.simple.hu/static/simple/g/favicon.ico">
    <link type="image/x-icon" rel="shortcut icon" href="https://www.simple.hu/static/simple/g/favicon.ico">
  
	<script type="text/javascript" src="demo/js/jquery.min.js"></script>
	<script type="text/javascript" src="demo/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="demo/js/scripts.js"></script>
</head>

<body>
<div class="container">
 
	<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php"><img width="220" id="logo" src="demo/img/simplepay_logo_240.png" class="img-responsive"></a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="active">
							<a href="http://simplepartner.hu/online_fizetesi_szolgaltatas.html"  target="_blank">simplepartner.hu</a>
						</li>

					</ul>
					
					<ul class="nav navbar-nav navbar-right">
						<li <?php echo $langActiveClassHu; ?> >
							<a href="index.php?guilang=HU">HU</a>
						</li>
						<li <?php echo $langActiveClassEn; ?> >
							<a href="index.php?guilang=EN">EN</a>
						</li>					
					</ul>

				</div>
				
	</nav>
			
	<div class="page-header">
		<h1>[ <?php echo $mydata['title'];?> ]</h1>
	</div>
 
</div>