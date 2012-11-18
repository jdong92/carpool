<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
 
<?php
session_start();
ini_set('display_errors', 'On');

include("navbar.php");

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" 
      type="image/png" 
      href="favicon.png">
	<title>Corvallis Classifieds - Home</title>
	
	<link rel="stylesheet" type="text/css" href="style.css" />
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="style-ie.css" />
	<![endif]-->
</head>

<body>

	<div id="page-wrap">
		<div id="inside">
			<div id="botright">
			<a href="http://www.chris-schuster.com/" target="_blank" style="color:#FFFFFF;">image credit</a>
			</div>
			
			<div id="header">
			<img src="header.png">
			</div>
		
			<div id="left-sidebar">
				<?php
					if (isset($_SESSION['username']) == 1)
						insertnavbar(1,0);
					else
						insertnavbar(0,0);
				?>

			</div>
	
			<div id="main-content">
						
				<h2>Welcome</h2>
				At Corvallis Classifieds you can buy, sell, or trade your stuff and reach a local audience.
				Sign up for an account to start posting or just feel free to browse the existing ads!<br><br>
				<center><p style="font-size:15px">	
				View ads:<br>
				<a href="buy.php">BUY</a> | <a href="sell.php">SELL</a> | <a href="trade.php">TRADE</a>
				</p></center>
			
			</div>
			
			<div style="clear: both;"></div>
		
		</div>
		
		<div style="clear: both;"></div>
	
	</div>

</body>

</html>