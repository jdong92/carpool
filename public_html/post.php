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
			<option>Buy</option>
			<option>Sell</option>
			<option>Trade</option>
			</select>
			<?php cats(''); ?>
			<br>
			Title:<br />
			<input type="text" name="title" size="50" /><br />


			Price:<br />
			<input type="text" name="price" size="50" /><br />

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
if ($_POST['title']=='' or $_POST['price']=='' or $_POST['textpost']=='' or $_POST['contact']=='') 
{
    error('One or more required fields were left blank.\\n'.'Please fill them in and try again.');
}

$type=mysql_real_escape_string(trim($_POST['type']));
$category=mysql_real_escape_string(trim($_POST['category']));
$title=mysql_real_escape_string(trim($_POST['title']));
$price=mysql_real_escape_string(trim($_POST['price']));
$textpost=mysql_real_escape_string(trim($_POST['textpost']));
$contact=mysql_real_escape_string(trim($_POST['contact']));
$datetime=date("d/m/y h:i");
$author=$_SESSION['username'];

if($type == "Buy")
    $query="INSERT INTO buyposts(category,title,price,author,text,datetime,contact)VALUES('$category','$title','$price','$author','$textpost','$datetime','$contact')";
elseif($type == "Sell")
	$query="INSERT INTO sellposts(category,title,price,author,text,datetime,contact)VALUES('$category','$title','$price','$author','$textpost','$datetime','$contact')";
elseif($type == "Trade")
	$query="INSERT INTO tradeposts(category,title,price,author,text,datetime,contact)VALUES('$category','$title','$price','$author','$textpost','$datetime','$contact')";



if (!mysql_query($query))
    error('A database error occurred in processing your submission.');

mysql_close();
header('Location: success.php');
?>
<?php
endif;
?>
