<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset='ISO-8859-1'">
	</head>
	</body>
<?php

include "db.php";

$query="select * from " . $stone_table . " where category in ('skifer', 'kvarsit', 'minera', 'fylitt')";
$result=mysql_query($query);
if(mysql_num_rows($result)>0){
	$column = 1;
	echo "<table align='center' border='0'>";
		echo "<tr>";
		while($row=mysql_fetch_array($result)){
			echo "<td><a href='stone.php?name=" . $row['name'] . "&id=" . $row['id'] . "'><img src='images/" . $row['thumbnail'] . "'/></a></td>";	
			if($column % 4 == 0) {
				echo "</tr><tr>";
			}
			$column++;
		}
		echo "</tr>";
	echo "</table>";
} else{
	echo "<center>Ingen sten fundet!</center>";	
}

?>
	</body>
</html>