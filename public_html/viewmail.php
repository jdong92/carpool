<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<?php 
// viewmail.php
session_start();
ini_set('display_errors', 'On');

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

include("common.php");
include("db.php");
include("navbar.php");

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" 
      type="image/png" 
      href="favicon.png">
	
	<title>Corvallis Classifieds - Viewing Message</title>
	
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
						
			<?php	
				dbConnect('nejadb-db');
				
				$mid = (int)mysql_real_escape_string(trim($_GET['mid']));
				
				$sql = 'SELECT * FROM mail WHERE mid=' . $mid;
				
				$result = mysql_query($sql) or die(mysql_error());
					
				if(mysql_num_rows($result) != 0)
				{
					$row = mysql_fetch_array($result);
					if($row['recip'] == $_SESSION['username'])
					{
						echo '<h2>Viewing Message: ' . htmlspecialchars($row['subject']) . '</h2>';
						echo 'Sent By: <b>' . htmlspecialchars($row['sender']) . '</b>';
						echo '<br>Date and Time: <b>' . $row['datetime'] . '</b>';
						echo '<br>Body:<br>';				
						echo htmlspecialchars($row['body']);
						echo '<br>';
						
						$sql = 'UPDATE mail SET new=0 WHERE mid=' . $mid;
						$result = mysql_query($sql) or die(mysql_error());
						
						echo '<br><br><a href="composemail.php?recip=' .htmlspecialchars($row['sender']). '">Reply</a>';
						echo ' | <a href="deletemail.php?mid=' .$mid. '">Delete</a>';
					}
					else 
					{
						echo 'You do not have permission to view this message/';	
					}
				}
				else
					{
						echo '<p>Invalid mail id.</p>';
					}
				mysql_close();	
			?>
			
			</div>
			
			<div style="clear: both;"></div>
		
		</div>
		
		<div style="clear: both;"></div>
	
	</div>

</body>

</html>