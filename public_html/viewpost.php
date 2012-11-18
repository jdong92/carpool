<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<?php 
// viewpost.php
session_start();
ini_set('display_errors', 'On');

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
	
	<title>Corvallis Classifieds - View Post</title>
	
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
				$type=$_GET['type'];
				
				dbConnect('nejadb-db');
				$id = mysql_real_escape_string(trim($_GET['id']));
				
				if($type == 'Buy')
					$sql = 'SELECT * FROM buyposts WHERE id=' . $id;
				elseif($type == 'Sell')
					$sql = 'SELECT * FROM sellposts WHERE id=' . $id;
				elseif($type == 'Trade')
					$sql = 'SELECT * FROM tradeposts WHERE id=' . $id;
				
				$result = mysql_query($sql) or die(mysql_error());
					
				if(mysql_num_rows($result) != 0):
					while($row = mysql_fetch_array($result))
					{
						
						echo '<h2>Viewing Post: ' . htmlspecialchars((stripcslashes($row['title']))) . '</h2>';
						echo 'Posted By: <b>' . htmlspecialchars($row['author']) . '</b>';
						echo '<br>Date and Time: <b>' . $row['datetime'] . '</b>';
						echo '<br>Price: <b>';
						if($type != 'Trade')
							echo '$';
						echo htmlspecialchars($row['price']) . '</b><br>';
						echo '<br>'.htmlspecialchars($row['text']);
						echo '<br><br>';
						echo '<p style="font-size:14px"><b>Contact Info:</b></p>';
						echo $row['contact'];
						echo '<br><br><a href="composemail.php?recip=' .htmlspecialchars($row['author']). '">Send Poster a Message</a>';
					}
				else:
					echo '<p>Invalid post id.</p>';
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