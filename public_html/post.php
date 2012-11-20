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
	
	<title>Corvallis Classifieds - Post an Ad</title>
	
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
						
			<h2>Post Ad</h2>
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

			Text:<br />
			<textarea name="textpost" rows="5" cols="60"></textarea><br />
			
			Contact:<br />
			<textarea name="contact" rows="3" cols="60"></textarea><br />
			

			<input type="submit" name="submitpost" value="Submit" />
			</form>
			
			</div>
			
			<div style="clear: both;"></div>
		
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

$carpoolid=mysql_real_escape_string(trim($_POST['carpoolid']));
$start=mysql_real_escape_string(trim($_POST['start']));
$end=mysql_real_escape_string(trim($_POST['end']));
$duration=mysql_real_escape_string(trim($_POST['duration']));
$date=mysql_real_escape_string(trim($_POST['date']));
$carid=mysql_real_escape_string(trim($_POST['carid']));
$numpass=mysql_real_escape_string(trim($_POST['numpass']));
$textpost=mysql_real_escape_string(trim($_POST['textpost']));
$contact=mysql_real_escape_string(trim($_POST['contact']));
$recur=mysql_real_escape_string(trim($_POST['recur']));
$datetime=date("d/m/y h:i");
$author=$_SESSION['username'];

if($type == "Add")
    $query = "INSERT INTO carpool (carpool_id, startingtime, endingingtime, datetime, duration, car_id, numberofpassengers, recurrencelevel) VALUES (uuid(),'$carid', '$start', '$end', '$date', '$duration', '$carid', '$numpass', '$recur')";
elseif($type == "Delete")
	$query="DELETE FROM carpool WHERE carpool_id = '$carpoolid'";
elseif($type == "Edit")
	$query="UPDATE carpool SET startingtime = '$start' endingtime = 'end' datetime = '$date' duration = '$duration' car_id = '$carid' numberofpassengers = '$numpass' recurrencelevel = '$recur' WHERE carpool_id = '$carpoolid'";



if (!mysql_query($query))
    error('A database error occurred in processing your submission.');

mysql_close();
header('Location: success.php');
?>
<?php
endif;
?>
