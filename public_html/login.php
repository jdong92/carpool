<?php 
// login.php
session_start();
ini_set('display_errors', 'On');

include("common.php");
include("db.php");
include("navbar.php");

if (isset($_SESSION['username']))
{

    $now = time(); // checking the time now when home page starts

    if($now > $_SESSION['expire'])
    {
        session_destroy();
    }
	else
	{
		header('Location: index.php');
	}
}
	
if (!isset($_POST['login'])):
    // Display the log in form
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" 
      type="image/png" 
      href="favicon.png">
	
	<title>Corvallis Classifieds - Login</title>
	
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
						
			<h2>Login</h2>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">

			Username:<br>
			<input type="text" name="username" size="30" /><br />


			Password: <br>
			<input type="password" name="password" size="30" /><br />
			<br>
			<input type="submit" name="login" value="Submit" />
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
// Process login submission
dbConnect('dongj-db');

if ($_POST['username']=='' or $_POST['password']=='') 
{
	error('One or more required fields were left blank.\\n'.'Please fill them in and try again.');
}

$UName = trim($_POST['username']);
$passhash = sha1(trim($_POST['password']));

$sql = "SELECT passhash FROM users WHERE username ='". mysql_real_escape_string($UName)."'";

$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);

if(!($row))
	error('Username incorrect. Please try again');

elseif ($row['passhash'] != sha1($_POST['password']))
		error('Login incorrect. Please try again. ');
else
{
	
	$_SESSION['username'] = $UName;
	$_SESSION['start'] = time();
	
	// end session in 30 minutes
	$_SESSION['expire'] = $_SESSION['start'] + (1440 * 60);
	header('Location: index.php');
	exit();
}
mysql_close();
?>

<?php
endif;
?>
