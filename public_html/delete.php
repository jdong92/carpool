<?php
$sql3 = 'SELECT * FROM driver WHERE username = "'.$_SESSION['username'];
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
}
?>
