<?php 
// post.php
session_start();
ini_set('display_errors', 'On');

include("common.php");
include("db.php");
include("navbar.php");


// Check if form is getting submitted

    // Display the user post form
	
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" 
      type="image/png" 
      href="favicon.png">
	
	<title>Search for a Carpool</title>
	
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
							
				<h2>Search for a Carpool</h2>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">

				<br>
				Carpool ID:<br />
				<input type="text" name="carpoolid" size="50" /><br />

				Starting After:<br />
				<input type="text" name="start" size="50" /><br />
				
				Ends Before:<br />
				<input type="text" name="end" size="50" /><br />
				
				Date:<br />
				<input type="text" name="date" size="50" /><br />
				
				Duration Less Than:<br />
				<input type="text" name="duration" size="50" /><br />
				
				Car ID:<br />
				<input type="text" name="carid" size="50" /><br />
				
				Recurrence level (frequent or one-time):<br />
				<input type="text" name="recur" size="50" /><br />

				<br/> <br/>
				
				<div id = "c">
				
				<div style="float: left; width: 47%;">
				Starting Location<br />	
					Address:<br />
					<input type="text" name="addressS" size="50" /><br />
					City:<br />
					<input type="text" name="cityS" size="50" /><br />
					State:<br />
					<input type="text" name="stateS" size="50" /><br />
				</div>

				<div style="float: right; width:47%;">
				Ending Location<br />
					Address:<br />
					<input type="text" name="addressE" size="50" /><br />
					City:<br />
					<input type="text" name="cityE" size="50" /><br />
					State:<br />
					<input type="text" name="stateE" size="50" /><br />
				</div>

				</div>

			<br /><br />
			<div style="clear: both;"></div>
			
			<input type="submit" name="submitsearch" value="Search Carpools" />

			</form>


						
			<form method="post" action="index.php">
			
			<input type ="submit" value = "Cancel" />
			
			</form>
			<br><br><br>
			<?php
				if (isset($_POST['submitsearch']))
				{
					dbConnect('nejadb-db');
	
					$carpoolid=mysql_real_escape_string(trim($_POST['carpoolid']));
					$start='%'.mysql_real_escape_string(trim($_POST['start'])).'%';
					$end='%'.mysql_real_escape_string(trim($_POST['end'])).'%';
					$duration=mysql_real_escape_string(trim($_POST['duration']));
					$date=mysql_real_escape_string(trim($_POST['date']));
					$carid=mysql_real_escape_string(trim($_POST['carid']));
					$numpass=0;
					$recur=mysql_real_escape_string(trim($_POST['recur']));
					$addressS = '%'.mysql_real_escape_string(trim($_POST['addressS'])).'%';
					$addressE = '%'.mysql_real_escape_string(trim($_POST['addressE'])).'%';
					$cityS = mysql_real_escape_string(trim($_POST['cityS']));
					$cityE = mysql_real_escape_string(trim($_POST['cityE']));
					$stateS = mysql_real_escape_string(trim($_POST['stateS']));
					$stateE = mysql_real_escape_string(trim($_POST['stateE']));
					$datetime=date("d/m/y h:i");
					
					$andc = 1;
					
					$sql = 'SELECT DISTINCT * FROM carpool C JOIN startinglocation S JOIN endinglocation E WHERE C.startinglocation_id = S.startinglocation_id AND C.endinglocation_id = E.endinglocation_id ';
					
					if($carpoolid != '')
					{
						if($andc != 0)
							$sql .= ' AND ';
						$sql .=' C.carpool_id = '. $carpoolid;
						$andc++;
					}
					if($start != '%%')
					{
						if($andc != 0)
							$sql .= ' AND ';
						$sql .=' C.startingtime LIKE "'. $start.'"';
						
						$andc++;
					}
					if($end != '%%')
					{
						if($andc != 0)
							$sql .= ' AND ';
						$sql .=' C.endingtime LIKE "'. $end.'"';
						
						$andc++;
					}
					if($date != '')
					{
						if($andc != 0)
							$sql .= ' AND ';
						$sql .=' C.datetime LIKE "'. $date . '"';
						 
						$andc++;
					}
					if($recur != '')
					{
						if($andc != 0)
							$sql .= ' AND ';
						$sql .=' C.recurrencelevel = '. $recur;
						 
						$andc++;
					}
					if($addressS != '%%')
					{
						if($andc != 0)
							$sql .= ' AND ';
						$sql .=' S.address LIKE  "'. $addressS . '"';
						 
						$andc++;
					}
					if($addressE != '%%')
					{
						if($andc != 0)
							$sql .= ' AND ';
						$sql .=' E.address LIKE  "'. $addressE . '"';
						 
						$andc++;
					}
					if($cityS != '')
					{
						if($andc != 0)
							$sql .= ' AND ';
						$sql .=' S.city LIKE "'. $cityS . '"';
						 
						$andc++;
					}
					if($cityE != '')
					{
						if($andc != 0)
							$sql .= ' AND ';
						$sql .=' E.city LIKE "'. $cityE . '"';
						 
						$andc++;
					}
					if($stateS != '')
					{
						if($andc != 0)
							$sql .= ' AND ';
						$sql .=' S.state LIKE "'. $stateS . '"';
						 
						$andc++;
					}
					if($stateE != '')
					{
						if($andc != 0)
							$sql .= ' AND ';
						$sql .=' E.state LIKE "'. $stateE . '"';
						 
						$andc++;
					}
							
					//$sql = 'select * from carpool';
					//echo($sql);
					$result = mysql_query($sql) or die(mysql_error());

					printCarpools($result);

					mysql_close();
					//header('Location: search.php');
				}
			?>
			</div>
			
			</div>
			

			
		</div>
		
		<div style="clear: both;"></div>
	
	</div>
	
	
	

</body>

</html>