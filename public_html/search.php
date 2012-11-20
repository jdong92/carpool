<?php 
// search.php
session_start();
ini_set('display_errors', 'On');

include("common.php");
include("db.php");
include("navbar.php");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" 
      type="image/png" 
      href="favicon.png">
	
	<title>Corvallis Classifieds - Search</title>
	
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
						
			<h2>Search</h2>
			<form method="GET" action="<?php echo $_SERVER['PHP_SELF']?>">
<!--
			<select name="type">
			<option>Buy</option>
			<option>Sell</option>
			<option>Trade</option>
			</select>
			<?php cats(''); ?>
			<br>
			Search Term:<br />
			<input type="text" name="searchterm1" size="50" /><br />
			AND (Optional)
			<input type="text" name="searchterm2" size="50" /><br />
			AND (Optional)
			<input type="text" name="searchterm3" size="50" /><br />
			AND (Optional)
			<input type="text" name="searchterm4" size="50" /><br />

			<input type="submit" name="submitsearch" value="Submit" />
-->
			</form>
			<br><br>
<?php
dbConnect('dongj-db');
$sqlquery = 'select * from carpool';
$result = mysql_query($sqlquery);
                    $num_results = mysql_num_rows($result);
                    
                    if ($num_results == 0) echo "<br/> There are no results.";
                    else
                    {
                        echo "<div style=\"font-size: 10pt; font-family: \'Lucida Console\'\">";
                        $spacing = ' &nbsp ';
                        echo "<table>
                                <tr>
                                    <td> <strong> CarpoolID </strong> $spacing </td>
                                    <td> <strong> StartTime </strong> $spacing </td>
                                    <td> <strong> EndTime </strong> $spacing </td>
				    <td> <strong> Datetime </strong> $spacing </td>
                                </tr>
                                ";
                        while($row=mysql_fetch_array($result))
                        {
                            $A=$row['carpool_id'];
                            $B=$row['startingtime'];
                            $C=$row['endingtime'];
			    $D=$row['datetime'];
                            
                            echo "
                                <tr>
                                    <td>$A $spacing </td>
                                    <td>$B $spacing </td>
                                    <td>$C $spacing </td>
				    <td>$D $spacing </td>
                                </tr>
                            ";
                        }
                        echo "
                        </table>";
                    }
?>

			<?php	
				if(isset($_GET['submitsearch']))
					{
						dbConnect('nejadb-db');
						$searchterm1 = '%'. mysql_real_escape_string(trim($_GET['searchterm1'])) . '%';
						$searchterm2 = '%'. mysql_real_escape_string(trim($_GET['searchterm2'])) . '%';
						$searchterm3 = '%'. mysql_real_escape_string(trim($_GET['searchterm3'])) . '%';
						$searchterm4 = '%'. mysql_real_escape_string(trim($_GET['searchterm4'])) . '%';
						
						$type = mysql_real_escape_string(trim($_GET['type']));
						$cat = mysql_real_escape_string(trim($_GET['category']));
						
						$firstpart = '<br>Search Results for "'.mysql_real_escape_string(trim($_GET['searchterm1']));
						$endpart = '" in '.$type. ':'.$cat.'...<br><br>';
						
						if($type == 'Buy')
							$sql = 'SELECT * FROM buyposts WHERE category="' . $cat.'" AND title LIKE "'. $searchterm1 . '"';
						elseif($type == 'Sell')
							$sql = 'SELECT * FROM sellposts WHERE category="' . $cat.'" AND title LIKE "'. $searchterm1 . '"';
						elseif($type == 'Trade')
							$sql = 'SELECT * FROM tradeposts WHERE category="' . $cat.'" AND title LIKE "'. $searchterm1 . '"';
						
						if($searchterm2 != '%%')
						{
							$sql .=' AND title LIKE "'. $searchterm2 . '"';
							$firstpart .= ' AND '.mysql_real_escape_string(trim($_GET['searchterm2']));
						}
						if($searchterm3 != '%%')
						{
							$sql .=' AND title LIKE "'. $searchterm3 . '"';
							$firstpart .= ' AND '.mysql_real_escape_string(trim($_GET['searchterm3']));
							
						}
						if($searchterm4 != '%%')
						{
							$sql .=' AND title LIKE "'. $searchterm4 . '"';
							$firstpart .= ' AND '.mysql_real_escape_string(trim($_GET['searchterm4']));
							
						}
						
						echo $firstpart.$endpart;


						
						$result = mysql_query($sql) or die(mysql_error());
					
						if(mysql_num_rows($result) != 0):
							while($row = mysql_fetch_array($result))
							{
								
							  echo '<a href="viewpost.php?id=' . $row['id'] . '&type='.$type.'">' . htmlspecialchars((stripcslashes($row['title']))) . '</a>';
							  echo '<br /><h6>Posted By: ' . stripslashes($row['author']) . '</h6>';
							  echo '<br>';
							}
						else:
							echo '<p>No posts to display!</p>';
						endif;      
							// id title price author text time date 
							mysql_close();	
					}	
			?>
			</div>
			
			<div style="clear: both;"></div>
		
		</div>
		
		<div style="clear: both;"></div>
	
	</div>

</body>

</html>