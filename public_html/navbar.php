<?php

function insertnavbar($authed,$extra)
{
	if (isset($_SESSION['username']))
    {
	$auth = '
		Logged in as: <font color=A9CF54>'.$_SESSION['username'].'</font><br>
		<a href="post.php">Create a Carpool</a><br>
		<a href="delete.php">Delete a Carpool</a><br>
		<a href="search.php">Search Carpools</a><br>
		<a href="logout.php">Log out</a>';
	}
	$notauth='
		Not logged in.. <br>
		<a href="login.php">Log in</a><br>
		<a href="post.php">Create a Carpool</a><br>
		<a href="search.php">Search Carpools</a><br>
		<a href="signup.php">Sign up</a>
		';
	
	$b = '<br><br><a href="javascript:history.back()">Back</a><br><a href="index.php">Home</a>';
	$final='';
	
	if($authed == 1)
		$final=$auth;
	else
		$final=$notauth;
	
	if($extra == 1)
		$final=$final.$b;
	
	echo $final;
}

function cats($default)
{
	
	$mystring = '<select name="category">
			<option>Computers</option>
			<option>Books</option>
			<option>Furniture</option>
			<option>Bikes</option>
			<option>Cars</option>
			<option>Electronics</option>
			<option>Other</option>
			</select>';
	
	if( $default != '')
	{
		$pos = strpos($mystring,$default)-1;
		$part1 = substr($mystring,0,$pos);
		$mystring = $part1.' selected="selected"'.substr($mystring,$pos);
	}
	
	echo $mystring;
}
?>