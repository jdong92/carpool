<?php // db.php

$dbhost = 'oniddb.cws.oregonstate.edu';
#$dbname = 'dongj-db';
#$dbuser = 'dongj-db';
#$dbpass = 'OoRXrzRGCxpLdzHT';
$dbname = 'johnsoaa-db';
$dbuser = 'johnsoaa-db';
$dbpass = 'ebNck9ifXg5KPFmo';

function dbConnect($db="")
{
    global $dbhost, $dbname, $dbuser, $dbpass;

	$mysql_handle = @mysql_connect($dbhost, $dbuser, $dbpass)
		or die("The site database appears to be down.");

	if ($db != "" and !@mysql_select_db($dbname, $mysql_handle))
		die("The site database is unavailable.");

	return $mysql_handle;
}

function htmlRow($rowtext) {
	$row = "<tr>";
	foreach($rowtext as $col) {
		$row = $row."<td>".$col."</td>";
	}
	echo $row."</tr>";
}

function getDriver($id) {
	$subquery = "select username from driver where carpool_id = $id";
	$subqueryresult = mysql_query($subquery);
	$usr = mysql_fetch_array($subqueryresult);
	return $usr['username'];
}

function getmoreinfo($id) {
	return '<a href="viewpost.php?id=' . $id . '">' . 'Info' . '</a>';
	return '';
}

#Expects a result containing 5 columns from the carpool table (see below)
#The DB connection must still be open as well
function printCarpools($result) {
	$style = "<div style=\"font-size: 10pt; font-family: \'Lucida Console\'\">";
	$space = ' &nbsp ';
	$num_results = mysql_num_rows($result);

	if ($num_results == 0)
		echo "<p>No matches were found.</p>";
	else {
		echo $style;
		echo "<table>";
		$colheaders = array(
			"<strong> Owner </strong> $space", 
			"<strong> ID </strong> $space", 
			"<strong> Start-Time </strong> $space", 
			"<strong> End-Time </strong> $space", 
			"<strong> Passengers </strong> $space", 
			"<strong> Date </strong> $space",
			"");
		htmlRow($colheaders);
		while ($sqlrow = mysql_fetch_array($result)) {
			$cpid=$sqlrow['carpool_id'];
			$start=$sqlrow['startingtime'];
			$end=$sqlrow['endingtime'];
			$date=$sqlrow['datetime'];
			$numpass=$sqlrow['numberofpassengers'];
			$driver = getDriver($cpid);
			$moreinfo = getmoreinfo($cpid);
			$rowtext = array(
				"$driver $space",
				"$cpid $space",
				"$start $space",
				"$end $space",
				"$numpass $space",
				"$date $space",
				"$moreinfo $space");
			htmlRow($rowtext);
		}
		echo "</table>";
	}
}

?>
