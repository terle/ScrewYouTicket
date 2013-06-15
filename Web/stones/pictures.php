<?php

	session_start();
	if(!session_is_registered(myusername)){
		header("location:login.php?l=pictures.php");
	}

include "db.php";

	if ($_SESSION['timeout'] + 15 * 60 < time()) {
		header("location:login.php?l=pictures.php");
	}

$pictures;

$stone_name;
$url;
$description;
$fk_stone;

$insertOk;

if(isset($_POST["insert"])){
	if($_POST["insert"]=="yes"){
		$pictures=$_POST["pictures"];

		$picture_arr = explode("\n", $pictures);

		foreach($picture_arr as $picture) {
			$picture_exploded = explode(";;", $picture);

			$stone_name = $picture_exploded[0];
			$url = $picture_exploded[1];
			$description = $picture_exploded[2];
			
			$row = mysql_query("select id from " . $stone_table . " where name = '" . $stone_name . "'");
				
			if(mysql_num_rows($row) > 0) {
				$id = mysql_fetch_array($row);
				$fk_stone = $id['id'];
			} else {
				echo "<center><font style='color: red'>FEJL: Ingen sten fundet med navnet: '" . $stone_name . "'. Ingen billeder indsat!</font></center>";
			}

			$query="insert into " . $picture_table . "(url, description, fk_stone) values('$url', '$description', '$fk_stone')";
			
			if(mysql_query($query)) {
				$insertOk = true;
			} else {
				$insertOk = false;
			}
		}
		if($insertOk) {
			echo("<center>Billede blev indsat!</center>");
		} else {
			echo "<center><font style='color: red'>FEJL: Intet billede indsat!</font></center>";
		}
	}
}

if(isset($_GET['operation'])){
	if($_GET['operation']=="delete") {
		$query="delete from " . $picture_table . " where id=".$_GET['id'];	
		if(mysql_query($query)) {
				echo "<center>Billede slettet!</center><br>";
		}
	}
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset='ISO-8859-1'">
	</head>
	<body>
		<a href="logout.php" style='float: right;'>Log ud</a/>
		<form method="post" action="pictures.php">
			<table align="center" border="0">
				<tr align="center">
					<td colspan="2">Format:</td>
				</tr>
				<tr>
					<th colspan="2">navn p&aring; sten;;navn p&aring; billedefil;;beskrivelse</th>
				</tr>
				<tr>
					<th colspan="2">&Eacute;n linie pr. billede!</th>
				</tr>
				<tr>
					<td>Pictures:</td>
					<td><textarea name="pictures" cols="60" rows="10"></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">
						<input type="hidden" name="insert" value="yes" />
						<input type="submit" value="Inds&aelig;t billede"/>
					</td>
				</tr>
				<tr>
					<th colspan="2">Bem&aelig;rk: billeder skal l&aelig;gges i 'images' mappen.</th>
				</tr>
				<tr>
					<th colspan="2">Ingen æ, ø eller å'er i filnavnene!</th>
				</tr>
			</table>
		</form>
<?php
$query = "select p.id as picture_id, s.name as stone_name, p.url as picture_url, p.description from " . $picture_table . " p inner join " . $stone_table . " s on s.id = p.fk_stone";
$result = mysql_query($query);
if(mysql_num_rows($result)>0){
	echo "<table align='center' border='1'>";
	echo "<tr>";
	echo "<th>Id</th>";
	echo "<th>Url</th>";
	echo "<th>Beskrivelse</th>";
	echo "<th>Sten navn</th>";
	echo "</tr>";
	while($row=mysql_fetch_array($result)) {
		echo "<tr>";
		echo "<td>" .$row['picture_id'] . "</td>";	
		echo "<td>" .$row['picture_url'] . "</td>";	
		echo "<td>" .$row['description'] . "</td>";
		echo "<td>" .$row['stone_name'] . "</td>";
		echo "<td><a href='pictures.php?operation=delete&id=".$row['picture_id']."'>Slet</a></td>";	
		echo "</tr>";
	}
	echo "</table>";
} else {
	echo "<center>Ingen billeder fundet!</center>";	
}
?>
	</body>
</html>