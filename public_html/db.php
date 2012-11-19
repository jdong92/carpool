<?php // db.php

$dbhost = 'oniddb.cws.oregonstate.edu';
$dbname = 'dongj-db';
$dbuser = 'dongj-db';
$dbpass = 'oniddbpassword';

function dbConnect($db="")
{
    global $dbhost, $dbname, $dbuser, $dbpass;

    $mysql_handle = @mysql_connect($dbhost, $dbuser, $dbpass)
        or die("The site database appears to be down.");

    if ($db != "" and !@mysql_select_db($dbname, $mysql_handle))
        die("The site database is unavailable.");

    return $mysql_handle;
}

?>
