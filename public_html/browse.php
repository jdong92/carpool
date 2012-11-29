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
	
	<title>Corvallis Hub - Browse</title>
	
	<link rel="stylesheet" type="text/css" href="style.css" />
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="style-ie.css" />
	<![endif]-->
</head>

<body>

	<div id="page-wrap">
		<div id="inside">
			
			<div id="header">
				<img src="header.png">
			</div>
		
			<div id="left-sidebar">
			</div>
	
			<div id="main-content">
			<!-- Start Main -->
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			<select name="type">
			<option>Buy</option>
			<option>Sell</option>
			<option>Trade</option>
			</select>
			<?php cats(''); ?>
			<input type="textbox" name= "kword" value="Keywords" size="30" onfocus="if (this.value=='Keywords') this.value='';"/>
			<input type="submit" name="submitgo" value="Go" />
			</form>
			<br>

			<?php	
				if(isset($_POST['submitgo']))
				{
					
					dbConnect('nejadb-db');
					$result = explode(' ', mysql_real_escape_string(trim($_POST['kword'])));
					
					$type = mysql_real_escape_string(trim($_POST['type']));
					$cat = mysql_real_escape_string(trim($_POST['category']));
					
					
					
					if($type == 'Buy')
						$sql = 'SELECT * FROM buyposts WHERE category="' . $cat . '"';
					elseif($type == 'Sell')
						$sql = 'SELECT * FROM sellposts WHERE category="' . $cat . '"';
					elseif($type == 'Trade')
						$sql = 'SELECT * FROM tradeposts WHERE category="' . $cat . '"';
					
					foreach($result as &$val)
					{
						$temp = '%'. $val . '%';
						$sql .=' AND title LIKE "'. $temp . '"';
					}
					
					$result = mysql_query($sql) or die(mysql_error());
				
					if(mysql_num_rows($result) != 0):
						while($row = mysql_fetch_array($result))
						{
							
						  echo '<a href="viewpost.php?id=' . $row['id'] . '&type='.$type.'">' . htmlspecialchars((stripcslashes($row['title']))) . '</a>';
						  echo '<br /><h6>Posted By: ' . stripslashes($row['author']) . '</h6>';
						  echo '<br>';
						}
					else:
						echo '<p>No posts to display!</p>';
					endif;      
						// id title price author text time date 
						mysql_close();	
				}	
			?>


			<!-- Start Main -->			
			</div>
			
			<div style="clear: both;"></div>
		
		</div>
		
		<div style="clear: both;"></div>
	
	</div>

</body>

</html>