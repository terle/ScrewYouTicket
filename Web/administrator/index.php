<?php
	session_start();
	if(!session_is_registered(myusername)){
		header("location:login.php");
	}
	
	include "db.php";
	
	$image_folder = "../images/";
	$address_query = "select id, name from address";
	$address_result = mysql_query($address_query);
		
	// Insert
	if(isset($_POST["insert"])){
		if($_POST["insert"]=="yes"){
			if ($_FILES["file"]["error"] > 0) {
				echo "Error: " . $_FILES["file"]["error"] . "<br>";
			} else {
				echo "Name: " . $_POST['name'] . "</br>";
				echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				echo "Type: " . $_FILES["file"]["type"] . "<br>";
				echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				echo "Stored in: " . $_FILES["file"]["tmp_name"];
  
				move_uploaded_file($_FILES["file"]["tmp_name"], $image_folder . $_FILES["file"]["name"]);
				echo "Stored in: " . "../images/" . $_FILES["file"]["name"];
			}		
		
			$event_date = $_POST["event_date"];
			$time_start = $_POST["time_start"];
			$time_end = $_POST["time_end"];
			$address_id = $_POST["address_id"];
			$isactive = $_POST["isactive"];
			$description = $_POST["description"];

			$insertevent = "insert into event(name, event_date, time_start, time_end, address_id, isactive, description) 
				values('$name', '$event_date', '$time_start', '$time_end', '$address_id', '$isactive', '$description')";
			$result = mysql_query($insertevent) or die(mysql_error());
			if($result) {
				$inserteventimage = "insert into event_images(event_id, image_url) values(" . mysql_insert_id() . ", '" . $_FILES["file"]["name"] . "')";
				echo($inserteventimage);
				$imageresult = mysql_query($inserteventimage) or die(mysql_error());
				echo "<center>Event oprettet! id: " . mysql_insert_id() . "</center><br>";
			}
		}
	}

	// Update
	if(isset($_POST["update"])){
		if($_POST["update"]=="yes"){
			$name = $_POST["name"];
			$event_date = $_POST["event_date"];
			$time_start = $_POST["time_start"];
			$time_end = $_POST["time_end"];
			$address_id = $_POST["address_id"];
			$isactive = $_POST["isactive"];
			$description = $_POST["description"];

			$query=
				"update event set 
					name='$name', 
					event_date='$event_date', 
					time_start='$time_start', 
					time_end='$time_end', 
					address_id='$address_id', 
					isactive='$isactive', 
					description='$description' 
				where id=".$_POST['id'];
				
			if(mysql_query($query)) {
				echo "<center>Event opdateret!</center><br>";
			}
		}
	}

	// Deactivate/activate event
	if(isset($_GET['operation'])){
		if($_GET['operation'] == "deactivate" || $_GET['operation'] == "activate"){
			$action = $_GET['isactive'];
			$query="update event set isactive = $action where id=".$_GET['id'];	
			if(mysql_query($query)) {
				echo "<center>Event deaktiveret!</center><br>";
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
		<form method="post" action="index.php" enctype="multipart/form-data">
			<table align="center" border="0">
				<tr>
					<td>Event navn:</td>
					<td><input type="text" name="name" /></td>
				</tr>
				<tr>
					<td>Dato:</td>
					<td><p><input type="text" id="datepicker" name="event_date" /></p></td>
				</tr>
				<tr>
					<td>Starttidspunkt:</td>
					<td><input type="text" id="starttime" name="time_start" /></td>
				</tr>
				<tr>
					<td>Sluttidspunkt:</td>
					<td><input type="text" id="endtime" name="time_end" /></td>
				</tr>
				<tr>
					<td>Aktivt event:</td>
					<td><input type="checkbox" name="isactive" /></td>
				</tr>
				<tr>
					<td>Beskrivelse af event:</td>
					<td><textarea rows="4" cols="50" name="description"></textarea></td>
				</tr>
				<tr>
					<td>Adresse:</td>
					<td>
						<select name="address_id">
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
					<td><input type="file" name="file" /></td>
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

	// Edit
	if(isset($_GET['operation'])){
		if($_GET['operation']=="edit"){
		
?>

		<form method="post" action="index.php">
			<table align="center" border="0">
				<tr>
					<td>Event navn:</td>
					<td><input type="text" name="name" value="<?php echo $_GET['name']; ?>" /></td>
				</tr>
				<tr>
					<td>Dato:</td>
					<td><input type="text" name="event_date" value="<?php echo $_GET['event_date']; ?>"/></td>
				</tr>
				<tr>
					<td>Start:</td>
					<td><input type="text" name="time_start" value="<?php echo $_GET['time_start']; ?>"/></td>
				</tr>
				<tr>
					<td>Slut:</td>
					<td><input type="text" name="time_end" value="<?php echo $_GET['time_end']; ?>"/></td>
				</tr>
				<tr>
					<td>Adresse id:</td>
					<td><input type="text" name="address_id" value="<?php echo $_GET['address_id']; ?>"/></td>
				</tr>
				<tr>
					<td>Aktiv:</td>
					<td><input type="text" name="isactive" value="<?php echo $_GET['isactive']; ?>"/></td>
				</tr>
				<tr>
					<td>Beskrivelse:</td>
					<td><input type="text" name="description" value="<?php echo $_GET['description']; ?>"/></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">
						<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
						<input type="hidden" name="update" value="yes" />
						<input type="submit" value="Opdater event"/>
					</td>
				</tr>
			</table>
		</form>

<?php
	}}
?>

<?php
	$query="select * from event";
	$result=mysql_query($query);
	if(mysql_num_rows($result)>0){	
		echo "<table align='center' border='1'>";
		echo "<tr>";
		echo "<th>Id</th>";
		echo "<th>Event navn</th>";
		echo "<th>Dato</th>";
		echo "<th>Start</th>";
		echo "<th>Slut</th>";
		echo "<th>Adresse id</th>";
		echo "<th>Er aktiv</th>";
		echo "<th>Beskrivelse</th>";
		echo "</tr>";
		while($row=mysql_fetch_array($result)){
			$activeString = $row['isactive'] == 1 ? "deaktiver" : "aktiver";
			$activeOperation = $row['isactive'] == 1 ? "deactivate&isactive=0" : "activate&isactive=1";

			echo "<tr>";
			echo "<td>".$row['id']."</td>";	
			echo "<td>".$row['name']."</td>";	
			echo "<td>".$row['event_date']."</td>";
			echo "<td>".$row['time_start']."</td>";
			echo "<td>".$row['time_end']."</td>";
			echo "<td>".$row['address_id']."</td>";
			echo "<td>".$row['isactive']."</td>";
			echo "<td>".$row['description']."</td>";
			echo "<td><a href='index.php?operation=edit&id=".$row['id']
				."&name=".$row['name']
				."&event_date=".$row['event_date']
				."&time_start=".$row['time_start']
				."&time_end=".$row['time_end']
				."&address_id=".$row['address_id']
				."&isactive=".$row['isactive']
				."&description=".$row['description']
				."'>rediger</a></td>";
			echo "<td><a href='index.php?operation=" . $activeOperation . "&id=".$row['id']."'>" . $activeString . "</a></td>";	
			echo "</tr>";
		}
		echo "</table>";
	} else{
		echo "<center>No Records Found!</center>";	
	}

?>
	</body>
</html>