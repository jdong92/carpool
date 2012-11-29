<?php
/*$sql3 = 'SELECT * FROM driver WHERE username = "'.$_SESSION['username'];
$result3 = mysql_query($sql3) or die(mysql_error());
if(mysql_num_rows($result) != 0){
  while($row = mysql_fetch_array($result))
	{
		echo '<p>'.$row['carpool_id'].'</p>';
	}
}
else{
	echo '<p>You don\'t own any carpools</p>';
}


if(isset($_GET['submitdelete'])) //submitdelete action from form
{
	dbconnect('nejadb-db');
	$carpool = mysql_real_escape_string(trim($_GET['carpoolid'])); //carpoolid from html form
	
	$sql = 'SELECT * FROM driver WHERE username = "'.$_SESSION['username'].'" AND carpool_id = '.$carpool;
	
	$result = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result) != 0)
	{
		$sql2 = 'DELETE FROM carpool WHERE carpool_id = '.$carpool;
		mysql_query($sql2);
	}
	else{
		echo '<p>No carpool to delete!</p>';
	}
	mysql_close();
}*/

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
	
	<title>Delete a carpool</title>
	
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
						
			<h2>Delete carpool</h2>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">

			<br>
			Carpool ID:<br />
			<input type="text" name="carpoolid" size="50" /><br />

			<br/> <br/>

			<div style="clear: both;"></div>
			
			<input type="submit" name="submitpost" value="Delete carpool" />
			</form>
			
			<br />
			
			<form method="post" action="index.php">
			
			<input type ="submit" value = "Cancel" />
			
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
dbConnect('johnsoaa-db');
if ($_POST['carpoolid']=='') 
{
    error('One or more required fields were left blank.\\n'.'Please fill them in and try again.');
}

$carpoolid=mysql_real_escape_string(trim($_POST['carpoolid']));
$author=$_SESSION['username'];
if ($carpoolid != '') {
  
		$query = "DELETE FROM carpool WHERE carpool_id=$carpoolid";
		if(!mysql_query($query))
			error("Couldn't delete");
}

mysql_close();
header('Location: success.php');
?>
<?php
endif;
?>
