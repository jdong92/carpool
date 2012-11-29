<?php	

	session_start();
	include("common.php");
	include("db.php");
	
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
			
	dbConnect('nejadb-db');
	
	$mid = (int)mysql_real_escape_string(trim($_GET['mid']));
	
	$sql = 'SELECT * FROM mail WHERE mid=' . $mid;
	
	$result = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result) != 0)
	{
		$row = mysql_fetch_array($result);
		if($row['recip'] == $_SESSION['username'])
		{
			$sqltwo = 'DELETE FROM mail WHERE mid=' . $mid;

			$resulttwo = mysql_query($sqltwo) or die(mysql_error());
		}
	}
	header('Location: mail.php');					
?>