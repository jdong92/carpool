<?php 
// post.php
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
// Check if form is getting submitted
if (!isset($_POST['submitpost'])):
    // Display the user post form
	
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" 
      type="image/png" 
      href="favicon.png">
	
	<title>Create a carpool</title>
	
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
						
			<h2>Create carpool</h2>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			<select name="type">
			<option>Add</option>
			<option>Delete</option>
			<option>Edit</option>
			</select>
			<br>
			Carpool ID:<br />
			<input type="text" name="carpoolid" size="50" /><br />


			Start time:<br />
			<input type="text" name="start" size="50" /><br />
			
			End time:<br />
			<input type="text" name="end" size="50" /><br />
			
			Date:<br />
			<input type="text" name="date" size="50" /><br />
			
			Duration:<br />
			<input type="text" name="duration" size="50" /><br />
			
			Number of passengers:<br />
			<input type="text" name="numpass" size="50" /><br />
			
			Car ID:<br />
			<input type="text" name="carid" size="50" /><br />
			
			Recurrence level (frequent or one-time):<br />
			<input type="text" name="recur" size="50" /><br />

			<br/> <br/>
			
			<div id = "c">
			
			<div id = "leftlocat">
			
				Starting Location<br />
				
				Address<br />
				<input type="text" name="addressS" size="50" /><br />
			
				City:<br />
				<input type="text" name="cityS" size="50" /><br />

				State:<br />
				<input type="text" name="stateS" size="50" /><br />

			</div>
			
			<div id = "rightlocat">
			
				Ending Location<br />
				
				Address<br />
				<input type="text" name="addressE" size="50" /><br />
			
				City:<br />
				<input type="text" name="cityE" size="50" /><br />

				State:<br />
				<input type="text" name="stateE" size="50" /><br />

			</div>
			
			</div>

			<div style="clear: both;"></div>
			
			<input type="submit" name="submitpost" value="Create carpool" />
			</form>
			
			<br />
			
			<form method="post" action="index.php">
			
			<input type ="submit" value = "cancel" />
			
			</form>
			
			
			</div>
			

			
		</div>
		
		<div style="clear: both;"></div>
	
	</div>
	
	
	

</body>

</html>

<?php
else:
// Process post submission
dbConnect('nejadb-db');
if ($_POST['carpoolid']=='') 
{
    error('One or more required fields were left blank.\\n'.'Please fill them in and try again.');
}

$type = mysql_real_escape_string(trim($_POST['type']));

$carpoolid=mysql_real_escape_string(trim($_POST['carpoolid']));
$start=mysql_real_escape_string(trim($_POST['start']));
$end=mysql_real_escape_string(trim($_POST['end']));
$duration=mysql_real_escape_string(trim($_POST['duration']));
$date=mysql_real_escape_string(trim($_POST['date']));
$carid=mysql_real_escape_string(trim($_POST['carid']));
$numpass=mysql_real_escape_string(trim($_POST['numpass']));
$recur=mysql_real_escape_string(trim($_POST['recur']));
$addressS = mysql_real_escape_string(trim($_POST['addressS']));
$addressE = mysql_real_escape_string(trim($_POST['addressE']));
$cityS = mysql_real_escape_string(trim($_POST['cityS']));
$cityE = mysql_real_escape_string(trim($_POST['cityE']));
$stateS = mysql_real_escape_string(trim($_POST['stateS']));
$stateE = mysql_real_escape_string(trim($_POST['stateE']));
$datetime=date("d/m/y h:i");
$author=$_SESSION['username'];

if($type == "Add"){
    
	$query = "INSERT INTO startinglocation (city, state, address) VALUES ('$cityS', '$stateS', '$addressS')";
	if(!mysql_query($query))
		error("Couldn't create a startinglocation");
	$stl = mysql_insert_id();

	error("$stl");
	
	$query = "INSERT INTO endinglocation (city, state, address) VALUES ('$cityE', '$stateE', '$addressE')";
	if(!mysql_query($query))
		error("Couldn't create an endinglocation");
	$endl = mysql_insert_id();
	
		
	$query = "INSERT INTO carpool (startingtime, endingingtime, datetime, duration, car_id, numberofpassengers, recurrencelevel, startinglocation_id, endinglocation_id) VALUES ('$start', '$end', '$date', '$duration', '$carid', '$numpass', '$recur', '$stl', '$endl')";
	
	if(!mysql_query($query))
		error("Couldn't create a carpool");
	
}elseif($type == "Delete")
	$query="DELETE FROM carpool WHERE carpool_id = '$carpoolid'";
elseif($type == "Edit")
	$query="UPDATE carpool SET startingtime = '$start' endingtime = 'end' datetime = '$date' duration = '$duration' car_id = '$carid' numberofpassengers = '$numpass' recurrencelevel = '$recur' WHERE carpool_id = '$carpoolid'";



mysql_close();
header('Location: success.php');
?>
<?php
endif;
?>
