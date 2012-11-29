<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<?php 
// buy.php
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
	
	<title>Corvallis Classifieds - Buy Posts</title>
	
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
						
			<h2>Looking to Buy</h2>
			<form method="get" action="<?php echo $_SERVER['PHP_SELF']?>">
			<?php 
				if(isset($_GET['category']))
					cats($_GET['category']); 
				else
					cats('');
			?>
			<input type="submit" value=" Submit " />
			</form>
			<br><br><br><br><br>
			<?php	
				if(isset($_GET['category']))
					{
						dbConnect('nejadb-db');
						$cat = mysql_real_escape_string(trim($_GET['category']));
					$sql = 'SELECT * FROM buyposts WHERE category="' . $cat.'"';
					$result = mysql_query($sql) or die(mysql_error());
					
					if(mysql_num_rows($result) != 0):
						while($row = mysql_fetch_array($result))
						{
							
						  echo '<a href="viewpost.php?id=' . $row['id'] . '&type=Buy">' . htmlspecialchars((stripcslashes($row['title']))) . '</a>';
						  echo '<br /><h6>Posted By: ' . htmlspecialchars($row['author']) . '</h6>';
						  echo '<br>';
						}
					else:
						echo '<big>No posts to display!</big>';
					endif;      
						// id title price author text time date 
						mysql_close();	
					}	
			?>
			
			</div>
			
			<div style="clear: both;"></div>
		
		</div>
		
		<div style="clear: both;"></div>
	
	</div>

</body>

</html>