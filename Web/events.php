<html>
	<head>
		<title>letbillet.com</title>
	</head>
	<body>
	<?php 
		$connect = mysql_connect("localhost","root","passme");
		mysql_select_db("screwyouticket",$connect);

		$event_query = "select * from events";
		$event_result = mysql_query($event_query);
		
		if(mysql_num_rows($event_result) > 0){
			echo("<table>");
			while($row = mysql_fetch_array($event_result)){
				if($row['isactive'] == true) {
					echo("<tr>");
					echo("<td>" . $row['name'] . "</td>");
					echo("<td>" . $row['event_date'] . "</td>");
					echo("<td>" . $row['time_start'] . "</td>");
					echo("<td>" . $row['time_end'] . "</td>");
					echo("<td>" . $row['description'] . "</td>");
					echo("</tr>");
				}
			}
			echo("</table>");
		}
	?>	
	</body>
</html>