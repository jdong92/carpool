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

				echo "<p> <strong> Driver: $driver </strong> </p>";
				$cpid = $cp_row['carpool_id'];
				echo "<p> Carpool ID: $cpid </p>";
				$pass = $cp_row['numberofpassengers'];
				echo "<p> Passenger Number: $pass </p>";
				$startt = $cp_row['startingtime'];
				echo "<p> Starting Time: $startt </p>";
				$endt = $cp_row['endingtime'];
				echo "<p> Ending Time: $endt </p>";
				$dur = $cp_row['duration'];
				echo "<p> Duration: $dur </p>";
				$rec = $cp_row['recurrencelevel'];
				echo "<p> Recurrence: $rec </p>";

				echo "<p> <strong> Passengers: </strong> </p>";
				while ($passrow = mysql_fetch_array($presult)) { #many rows
					$name = $passrow['username'];
					echo "<p> &nbsp $name </p>";
				}

				$query = "select * from startinglocation where startinglocation_id=$startid";
				$startlocr = mysql_query($query);
				$startloc = mysql_fetch_array($startlocr); #only one row
				$query = "select * from endinglocation where endinglocation_id=$endid";
				$endlocr = mysql_query($query);
				$endloc = mysql_fetch_array($endlocr); #only one row

				echo "<p> <strong> Starting Location: </strong> </p>";
				$address = $startloc['address'];
				echo "<p> Address: $address </p>";
				$zipcode = $startloc['zipcode'];
				echo "<p> Zipcode: $zipcode </p>";
				$city = $startloc['city'];
				echo "<p> City: $city </p>";
				$state = $startloc['state'];
				echo "<p> State: $state </p>";
				$long = $startloc['longitude'];
				echo "<p> Longitude: $long </p>";
				$lat = $startloc['latitude'];
				echo "<p> Latitude: $lat </p>";

				echo "<p> <strong> Ending Location: </strong> </p>";
				$address = $endloc['address'];
				echo "<p> Address: $address </p>";
				$zipcode = $endloc['zipcode'];
				echo "<p> Zipcode: $zipcode </p>";
				$city = $endloc['city'];
				echo "<p> City: $city </p>";
				$state = $endloc['state'];
				echo "<p> State: $state </p>";
				$long = $endloc['longitude'];
				echo "<p> Longitude: $long </p>";
				$lat = $endloc['latitude'];
				echo "<p> Latitude: $lat </p>";



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
				// 		echo '<p style="font-size:14px"><b>Contact Info:</b></p>';
				// 		echo $row['contact'];
				// 		echo '<br><br><a href="composemail.php?recip=' .htmlspecialchars($row['author']). '">Send Poster a Message</a>';
				// 	}
				// else:
				// 	echo '<p>Invalid post id.</p>';
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