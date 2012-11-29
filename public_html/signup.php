<?php 
// signup.php
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
		header('Location: login.php');
    }
	else
	{
		header('Location: index.php');
	}
}
    		
// Check if form is getting submitted
if (!isset($_POST['submitok'])):
    // Display the user signup form
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" 
      type="image/png" 
      href="favicon.png">
	
	<title>Corvallis Classifieds - Sign Up</title>
	
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
						
			<h2>Sign Up</h2>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">

			Username:<br />
			<input type="text" name="username" size="30" /><br />


			Password:<br />
			<input type="password" name="password" size="30" /><br />

			E-Mail:<br />
			<input type="text" name="email" size="30" /><br />
			<br>
			<input type="submit" name="submitok" value="Submit" />
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
// Process signup submission
dbConnect('nejadb-db');
if ($_POST['username']=='' or $_POST['email']=='') 
{
    error('One or more required fields were left blank.\\n'.'Please fill them in and try again.');
}

// Check for existing user with the new id

$sql = "SELECT COUNT(*) FROM users WHERE username = '$_POST[username]'";

$result = mysql_query($sql);

if (!$result) 
{
    error('A database error occurred in processing your submission.');
}

if (@mysql_result($result,0,0)>0) 
{
    error('A user already exists with your chosen username.\\n Please try another.');
}

$UName = mysql_real_escape_string(trim($_POST['username']));
$passhash = sha1($_POST['password']);
$email = mysql_real_escape_string(trim($_POST['email']));

$query="INSERT INTO users (username,email,passhash)VALUES ('".$UName."','".$email."','".$passhash."')";

if (!mysql_query($query))
    error('A database error occurred in processing your submission.');
mysql_close();
header('Location: success.php');

?>
<?php
endif;
?>