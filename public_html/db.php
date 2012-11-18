<?php // db.php
 
$dbhost = '127.0.0.1';
$dbuser = 'root';
$dbpass = '2SSNYPpeE5ldBeu2';
 
function dbConnect($db="") 
{
    global $dbhost, $dbuser, $dbpass;
    
    $dbcnx = @mysql_connect($dbhost, $dbuser)
            or die("The site database appears to be down.");
    
    if ($db!="" and !@mysql_select_db($db))
        die("The site database is unavailable.");
 
    return $dbcnx;
}

?>
