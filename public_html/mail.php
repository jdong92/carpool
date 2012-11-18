<?php 
// mail.php
session_start();
ini_set('display_errors', 'On');

include("common.php");
include("db.php");
include("navbar.php");

if(!isset($_SESSION['username']))
{
	header('Location: login.php');
}
else
{

    $now = time(); // checking the time now when home page starts

    if($now > $_SESSION['expire'])
    {
        session_destroy();
        header('Location: login.php');
    }
}

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" 
      type="image/png" 
      href="favicon.png">
	
	<title>Corvallis Classifieds - Mail</title>
	
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
						insertnavbar(1,1);
					else
						insertnavbar(0,1);
				?>

			</div>
	
			<div id="main-content">
						
			<h2>Inbox</h2>
			<?php	
				dbConnect('nejadb-db');

				$sql = 'SELECT * FROM mail WHERE recip="' . $_SESSION['username'] . '"';


				$result = mysql_query($sql) or die(mysql_error());

				if(mysql_num_rows($result) != 0):
				while($row = mysql_fetch_array($result))
				{	
					echo '<a href="viewmail.php?mid=' . $row['mid'].'">' . htmlspecialchars((stripcslashes($row['subject']))) . '</a>';
					if($row['new'] == 1)
						echo '<font color=red><b> - New</b></font><br>';			
					echo '<br /><h3>From: ' . stripslashes($row['sender']) . '</h3>';
					echo '<br>';
				}
				else:
					echo '<p>You have no mail!</p>';
				endif;      

				mysql_close();

				?>
			
			</div>
			
			<div style="clear: both;"></div>
		
		</div>
		
		<div style="clear: both;"></div>
	
	</div>

</body>

</html>