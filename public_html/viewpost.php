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
				dbConnect('nejadb-db');
				$id = mysql_real_escape_string(trim($_GET['id']));
				$query = "select * from carpool where carpool_id=$id";
				$cpresult = mysql_query($query) or die(mysql_error());
				$query = "select username from driver where carpool_id=$id";
				$dresult = mysql_query($query) or die(mysql_error());
				$query = "select username from passenger where carpool_id=$id";
				$presult = mysql_query($query) or die(mysql_error());

				$cp_row = mysql_fetch_array($cpresult); #only one row
				$startid = $cp_row['startinglocation_id'];
				$endid = $cp_row['endinglocation_id'];
				$driver = mysql_fetch_array($dresult); #only one row
				$driver = $driver['username'];

				echo "<strong> Car Information </strong>";
				echo "<br> Driver: $driver";
				$cpid = $cp_row['carpool_id'];
				echo "<br>Carpool ID: $cpid";
				$pass = $cp_row['numberofpassengers'];
				echo "<br>Passenger Number: $pass";
				$startt = $cp_row['startingtime'];
				echo "<br>Starting Time: $startt";
				$endt = $cp_row['endingtime'];
				echo "<br>Ending Time: $endt";
				$dur = $cp_row['duration'];
				echo "<br>Duration: $dur";
				$rec = $cp_row['recurrencelevel'];
				echo "<br>Recurrence: $rec";

				echo "<br><br><strong> Passengers: </strong>";
				while ($passrow = mysql_fetch_array($presult)) { #many rows
					$name = $passrow['username'];
					echo "<br>$name";
				}

				$query = "select * from startinglocation where startinglocation_id=$startid";
				$startlocr = mysql_query($query);
				$startloc = mysql_fetch_array($startlocr); #only one row
				$query = "select * from endinglocation where endinglocation_id=$endid";
				$endlocr = mysql_query($query);
				$endloc = mysql_fetch_array($endlocr); #only one row

				echo "<br><br> <strong> Starting Location: </strong>  ";
				$address = $startloc['address'];
				echo "<br> Address: $address  ";
				$zipcode = $startloc['zipcode'];
				echo "<br> Zipcode: $zipcode  ";
				$city = $startloc['city'];
				echo "<br> City: $city  ";
				$state = $startloc['state'];
				echo "<br> State: $state  ";
				$long = $startloc['longitude'];
				echo "<br> Longitude: $long  ";
				$lat = $startloc['latitude'];
				echo "<br> Latitude: $lat  ";

				echo "<br><br> <strong> Ending Location: </strong>  ";
				$address = $endloc['address'];
				echo "<br> Address: $address  ";
				$zipcode = $endloc['zipcode'];
				echo "<br> Zipcode: $zipcode  ";
				$city = $endloc['city'];
				echo "<br> City: $city  ";
				$state = $endloc['state'];
				echo "<br> State: $state  ";
				$long = $endloc['longitude'];
				echo "<br> Longitude: $long  ";
				$lat = $endloc['latitude'];
				echo "<br> Latitude: $lat  ";



				// $type=$_GET['type'];
				// if($type == 'Buy')
				// 	$sql = 'SELECT * FROM buyposts WHERE id=' . $id;
				// elseif($type == 'Sell')
				// 	$sql = 'SELECT * FROM sellposts WHERE id=' . $id;
				// elseif($type == 'Trade')
				// 	$sql = 'SELECT * FROM tradeposts WHERE id=' . $id;
				
				// $result = mysql_query($sql) or die(mysql_error());
					
				// if(mysql_num_rows($result) != 0):
				// 	while($row = mysql_fetch_array($result))
				// 	{
						
				// 		echo '<h2>Viewing Post: ' . htmlspecialchars((stripcslashes($row['title']))) . '</h2>';
				// 		echo 'Posted By: <b>' . htmlspecialchars($row['author']) . '</b>';
				// 		echo '<br>Date and Time: <b>' . $row['datetime'] . '</b>';
				// 		echo '<br>Price: <b>';
				// 		if($type != 'Trade')
				// 			echo '$';
				// 		echo htmlspecialchars($row['price']) . '</b><br>';
				// 		echo '<br>'.htmlspecialchars($row['text']);
				// 		echo '<br><br>';
				// 		echo '<p style="font-size:14px"><b>Contact Info:</b> ';
				// 		echo $row['contact'];
				// 		echo '<br><br><a href="composemail.php?recip=' .htmlspecialchars($row['author']). '">Send Poster a Message</a>';
				// 	}
				// else:
				// 	echo '<br>Invalid post id. ';
				// endif;      

				mysql_close();	
			?>	
			
			</div>
			
			<div style="clear: both;"></div>
		
		</div>
		
		<div style="clear: both;"></div>
	
	</div>

</body>

</html>