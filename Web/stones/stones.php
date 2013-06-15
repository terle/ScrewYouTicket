<?php
	session_start();
	if(!session_is_registered(myusername)){
		header("location:login.php?l=stones.php");
	}


include "db.php";

	if ($_SESSION['timeout'] + 15 * 60 < time()) {
		header("location:login.php?l=stones.php");
	}

$stones;

$name;
$category;
$color;
$description;
$thumbnail;

$insertOk;

if(isset($_POST["insert"])){
	if($_POST["insert"]=="yes"){
		$stones=$_POST["stones"];

		$stone_arr = explode("\n", $stones);

		foreach($stone_arr as $stone) {
			$stone_exploded = explode(";;", $stone);

			$name = $stone_exploded[0];
			$category = $stone_exploded[1];
			$color = $stone_exploded[2];
			$description = $stone_exploded[3];
			$thumbnail = $stone_exploded[4];

			$query="insert into " . $stone_table . "(name, category, color, description, thumbnail) values('$name', '$category', '$color', '$description', '$thumbnail')";
			if(mysql_query($query)) {
				$insertOk = true;
			} else {
				$insertOk = false;
			}
		}
		if($insertOk) {
			echo("<center>Sten blev indsat!</center>");
		} else {
			echo("<center><font style='color:red'>FEJL: Stenen '" . $name . "' findes allerede i forvejen</font></center>");
		}
	}
}

if(isset($_GET['operation'])){
	if($_GET['operation']=="delete"){
		$query="delete from " . $stone_table . " where id=".$_GET['id'];	
		if(mysql_query($query)) {
			echo "<center>Sten slettet!</center><br>";
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
		<form method="post" action="stones.php">
			<table align="center" border="0">
				<tr align="center">
					<td colspan="3">Format:</td>
				</tr>
				<tr>
					<th colspan="3">navn p&aring; sten;;kategori;;farve;;beskrivelse;;thumbnail af sten</th>
				</tr>
				<tr>
					<th colspan="3">&Eacute;n linie pr. sten!</th>
				</tr>
				<tr>
					<td>Sten:</td>
					<td><textarea name="stones" cols="60" rows="10"></textarea></td>
					<td><b>Farver skal skrives uden æ, ø eller å:</b></br>rød = roed</br>blå = blaa</br>grøn = groen</br>osv.</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">
						<input type="hidden" name="insert" value="yes" />
						<input type="submit" value="Inds&aelig;t sten"/>
					</td>
				</tr>
				<tr>
					<th colspan="2">Bem&aelig;rk: billeder skal l&aelig;gges i 'images' mappen.</th>
				</tr>
			</table>
		</form>

<?php
	$query="select * from " . $stone_table;
	$result=mysql_query($query);
	if(mysql_num_rows($result)>0){
		echo "<table align='center' border='1' style='margin-left: 30px; margin-right:30px;'>";
		echo "<tr>";
		echo "<th>Id</th>";
		echo "<th>Navn</th>";
		echo "<th>Kategori</th>";
		echo "<th>Farve</th>";
		echo "<th>Beskrivelse</th>";
		echo "<th>Thumbnail</th>";
		echo "</tr>";
		
		while($row=mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>".$row['id']."</td>";	
			echo "<td>".$row['name']."</td>";	
			echo "<td>".$row['category']."</td>";
			echo "<td>".$row['color']."</td>";
			echo "<td style='width: auto;'>".$row['description']."</td>";
			echo "<td>".$row['thumbnail']."</td>";
			echo "<td><a href='stones.php?operation=delete&id=".$row['id']."'>Slet</a></td>";	
			echo "</tr>";
		}
		echo "</table>";
	} else{
		echo "<center>Ingen sten i databasen!</center>";	
	}
?>
	</body>
</html>