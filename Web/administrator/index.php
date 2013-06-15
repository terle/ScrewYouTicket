<?php
	session_start();
	if(!session_is_registered(myusername)){
		header("location:login.php");
	}

	$connect = mysql_connect("terle.dk:3306","ticketsAdmin","minpikerhaard");
	mysql_select_db("screwyouticket",$connect);
	$username;
	$password;
	
	$address_query = "select id, name from address";
	$address_result = mysql_query($address_query);
		
	if(isset($_POST["insert"])){
		if($_POST["insert"]=="yes"){
			$username=$_POST["username"];
			$password=$_POST["password"];

			$query="insert into user(username, password) values('$username', '$password')";
			if(mysql_query($query)) {
				echo "<center>Record Inserted!</center><br>";
			}
		}
	}

	if(isset($_POST["update"])){
		if($_POST["update"]=="yes"){
			$username=$_POST["username"];
			$password=$_POST["password"];

			$query="update user set username='$username' , password='$password' where id=".$_POST['id'];
			if(mysql_query($query)) {
				echo "<center>Record Updated</center><br>";
			}
		}
	}

	if(isset($_GET['operation'])){
		if($_GET['operation']=="delete"){
			$query="delete from user where id=".$_GET['id'];	
			if(mysql_query($query)) {
				echo "<center>Record Deleted!</center><br>";
			}
		}
	}
?>

<html>
	<head>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  		<script src="code/jquery.ui.timepicker.js"></script>
  		<link rel="stylesheet" href="code/jquery.ui.timepicker.css" />
  		<script>
		  $(function() {
		    $( "#datepicker" ).datepicker();
		  });
		  $(function() {
		  	$( "#starttime" ).timepicker();
		  });
		  $(function() {
		  	$( "#endtime" ).timepicker();
		  });
		</script>
	</head>
	<body>
		<form method="post" action="index.php">
			<table align="center" border="0">
				<tr>
					<td>Event navn:</td>
					<td><input type="text" name="eventname" /></td>
				</tr>
				<tr>
					<td>Dato:</td>
					<td><p><input type="text" id="datepicker" name="date" /></p></td>
				</tr>
				<tr>
					<td>Starttidspunkt:</td>
					<td><input type="text" id="starttime" name="starttime" /></td>
				</tr>
				<tr>
					<td>Sluttidspunkt:</td>
					<td><input type="text" id="endtime" name="endtime" /></td>
				</tr>
				<tr>
					<td>Aktivt event:</td>
					<td><input type="checkbox" name="isactive" /></td>
				</tr>
				<tr>
					<td>Beskrivelse af event:</td>
					<td><textarea rows="4" cols="50"></textarea></td>
				</tr>
				<tr>
					<td>Adresse:</td>
					<td>
						<select>
							<option value="">V&aelig;lg</option>
  							<option value="new">Ny adresse</option>
  							<?php
								if(mysql_num_rows($address_result)>0){
									while($row=mysql_fetch_array($address_result)){
										echo("<option value=" . $row['id'] . ">" . $row['name'] . "</option>");
									}
  								}
  							?>
						</select>
					</td>
				</tr>
				<tr>
					<tr>
						<td>Vej:</td>
						<td><input type="text" name="streetname"/></td>
					</tr>
					<tr>
						<td>Nummer:</td>
						<td><input type="text" name="streetnumber"/></td>
					</tr>
					<tr>
						<td>Navn:</td>
						<td><input type="text" name="name"/></td>
					</tr>
					<tr>
						<td>Postnr.:</td>
						<td><input type="text" name="zipcode"/></td>
					</tr>
					<tr>
						<td>By:</td>
						<td><input type="text" name="town"/></td>
					</tr>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">
						<input type="hidden" name="insert" value="yes" />
						<input type="submit" value="Opret event"/>
					</td>
				</tr>
			</table>
		</form>

<?php

	if(isset($_GET['operation'])){
		if($_GET['operation']=="edit"){
?>

		<form method="post" action="index.php">
			<table align="center" border="0">
				<tr>
					<td>username:</td>
					<td><input type="text" name="username" value="<?php echo $_GET['username']; ?>" /></td>
				</tr>
				<tr>
					<td>password:</td>
					<td><input type="text" name="password" value="<?php echo $_GET['password']; ?>"/></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">
						<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
						<input type="hidden" name="update" value="yes" />
						<input type="submit" value="update Record"/>
					</td>
				</tr>
			</table>
		</form>

<?php
	}}
?>

<?php
	$query="select * from user";
	$result=mysql_query($query);
	if(mysql_num_rows($result)>0){
		echo "<table align='center' border='1'>";
		echo "<tr>";
		echo "<th>Id</th>";
		echo "<th>Username</th>";
		echo "<th>Password</th>";
		echo "</tr>";
		while($row=mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>".$row['id']."</td>";	
			echo "<td>".$row['username']."</td>";	
			echo "<td>".$row['password']."</td>";
			echo "<td><a href='index.php?operation=edit&id=".$row['id']."&username=".$row['username']."&password=".$row['password']."'>edit</a></td>";
			echo "<td><a href='index.php?operation=delete&id=".$row['id']."'>delete</a></td>";	
			echo "</tr>";
		}
		echo "</table>";
	} else{
		echo "<center>No Records Found!</center>";	
	}

?>
	</body>
</html>