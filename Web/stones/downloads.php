<?php
	session_start();
	if(!session_is_registered(myusername)){
		header("location:login.php?l=downloads.php");
	}

include "db.php";

	if ($_SESSION['timeout'] + 15 * 60 < time()) {
		header("location:login.php?l=downloads.php");
	}

$downloads;

$stone_name;
$url;
$description;
$fk_stone;

$insertOk;

if(isset($_POST["insert"])){
	if($_POST["insert"]=="yes"){
		$downloads=$_POST["downloads"];

		$download_arr = explode("\n", $downloads);

		foreach($download_arr as $download) {
			$download_exploded = explode(";;", $download);

			$stone_name = $download_exploded[0];
			$url = $download_exploded[1];
			$description = $download_exploded[2];
			
			$row = mysql_query("select id from " . $stone_table . " where name = '" . $stone_name . "'");
				
			if(mysql_num_rows($row) > 0) {
				$id = mysql_fetch_array($row);
				$fk_stone = $id['id'];
			} else {
				echo "<center><font style='color: red'>FEJL: Ingen sten fundet med navnet: '" . $stone_name . "'. Ingen download indsat!</font></center>";
				return;
			}

			$query="insert into " . $download_table . "(url, description, fk_stone) values('$url', '$description', '$fk_stone')";
			
			if(mysql_query($query)) {
				$insertOk = true;
			} else {
				$insertOk = false;
			}
		}
		if($insertOk) {
			echo("<center>Download blev indsat!</center>");
		} else {
			echo "<center><font style='color: red'>FEJL: Ingen download indsat!</font></center>";
		}
	}
}

if(isset($_GET['operation'])){
	if($_GET['operation']=="delete"){
		$query="delete from " . $download_table . " where id=".$_GET['id'];	
		if(mysql_query($query)) {
			echo "<center>Download slettet!</center><br>";
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
		<form method="post" action="downloads.php">
			<table align="center" border="0">
				<tr align="center">
					<td colspan="2">Format:</td>
				</tr>
				<tr>
					<th colspan="2">navn p&aring; sten;;navn p&aring; downloadfil;;beskrivelse</th>
				</tr>
				<tr>
					<th colspan="2">&Eacute;n linie pr. download!</th>
				</tr>
				<tr>
					<td>Downloads:</td>
					<td><textarea name="downloads" cols="60" rows="10"></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">
						<input type="hidden" name="insert" value="yes" />
						<input type="submit" value="Inds&aelig;t download"/>
					</td>
				</tr>
				<tr>
					<th colspan="2">Bem&aelig;rk: filer til download skal l&aelig;gges i 'downloads' mappen.</th>
				</tr>
				<tr>
					<th colspan="2">Ingen æ, ø eller å'er i filnavnene!</th>
				</tr>
			</table>
		</form>
<?php
$query="select d.id as download_id, s.name as stone_name, d.url as download_url, d.description from " . $download_table . " d inner join " . $stone_table . " s on s.id = d.fk_stone";
$result=mysql_query($query);
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
		echo "<td>" .$row['download_id'] . "</td>";	
		echo "<td>" .$row['download_url'] . "</td>";	
		echo "<td>" .$row['description'] . "</td>";
		echo "<td>" .$row['stone_name'] . "</td>";
		echo "<td><a href='downloads.php?operation=delete&id=".$row['download_id']."'>Slet</a></td>";	
		echo "</tr>";
	}
	echo "</table>";
}
else{
echo "<center>Ingen downloads fundet!</center>";	
}

?>
	</body>
</html>