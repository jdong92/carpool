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

<?php 
dbConnect('dongj-db'); //Changed DB table

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" 
      type="image/png" 
      href="favicon.png">
	
	<title>Add passenger to carpool</title>
	
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
						
			<h2>Add passenger to carpool</h2>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
			
			
			
			Carpool ID:<br />
			<input type="text" name="carpoolid" size="50" /><br /><br>
			
			Passenger Username:<br />
			<input type="text" name="userid" size="50" />
			<br><br>
			<input type="submit" name="submitpost" value="Add Passenger" />
			

			</form>
						
			<form method="post" action="index.php">
			<br>
			<input type ="submit" value = "Cancel" />
			
			</form>
			</div>
			
			</div>
			

			
		</div>
		
		<div style="clear: both;"></div>
	
	</div>
	
	
	

</body>

</html>

<?php
else:
// Process post submission
//dbConnect('dongj-db'); //Changed DB table

$carpoolid=mysql_real_escape_string(trim($_POST['carpoolid']));
$datetime=date("d/m/y h:i");
$author=$_SESSION['username'];

if ($_POST['carpoolid']== '' and $type != "Add") 
{
    error('The carpool ID field was left blank.\\n'.'Please fill it in and try again.');
}
elseif ($type != "Add") {
	$getownerquery = "SELECT username FROM driver WHERE carpool_id='$carpoolid'";
	$result = mysql_query($getownerquery);
	$row = mysql_fetch_array($result);
	if (mysql_num_rows($result) != 0 and $row['username'] == $author) {
	}
	else {
		error("You don't own that carpool");
	}
}
mysql_close();
header('Location: success.php');
?>

<?php
endif;
?>