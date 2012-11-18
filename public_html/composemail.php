<?php
// composemail.php
session_start();
ini_set('display_errors', 'On');

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
			
include("common.php");
include("db.php");
include("navbar.php");

// Check if form is getting submitted
if (!isset($_POST['submitmail'])):
    // Display the user post form
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" 
      type="image/png" 
      href="favicon.png">
	
	<title>Corvallis Classifieds - Compose Mail</title>
	
	<link rel="stylesheet" type="text/css" href="style.css" />
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="style-ie.css" />
	<![endif]-->
	
	<?php
	if (isset($_GET['recip']) == 1)
	{
		echo'<script type="text/javascript">document.getElementById(“recip”).value = “'.$_GET['recip'].'”;</script>';
	}
	?>
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
						
			<h2>Compose Mail</h2>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
    
	
			Recipient:<br />
			<?php
			if (isset($_GET['recip']) == 1)
			{ ?>
				<input type="text" name="recip" value="<?php echo $_GET['recip']; ?>" size="50" /><br />
			<?php
			}
			else
			{
			?>
				<input type="text" name="recip" size="50" /><br />
			<?php
			}
			?>
			Subject:<br />
			<input type="text" name="subject" size="50" /><br />

			Body:<br />
			<textarea name="body" rows="5" cols="60"></textarea><br />
			

			<input type="submit" name="submitmail" value="Submit" />
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
if ($_POST['recip']=='' or $_POST['subject']=='' or $_POST['body']=='') 
{
    error('One or more required fields were left blank.\\n'.'Please fill them in and try again.');
}

$recip=mysql_real_escape_string(trim($_POST['recip']));
$sql = 'SELECT * FROM users WHERE username="' . $recip.'"';
$result = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($result) != 0)
{

	$recip=mysql_real_escape_string(trim($_POST['recip']));
	$subject=mysql_real_escape_string(trim($_POST['subject']));
	$body=mysql_real_escape_string(trim($_POST['body']));
	$sender=$_SESSION['username'];
	$datetime=date("d/m/y h:i");


	$query="INSERT INTO mail(subject,body,datetime,sender,recip)VALUES('$subject','$body','$datetime','$sender','$recip')";

	if (!mysql_query($query))
		error('A database error occurred in processing your submission.');
		
	header('Location: success.php');
}
else
	error('No user with that name exists');

mysql_close();
?>
<?php
endif;
?>
