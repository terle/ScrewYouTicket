<?php
	ob_start();
	header('Content-type: text/html; charset=utf-8');
?>

<html>
	<head>
		<title>letbillet.com</title>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  		<script>
  			$(function(){
				$('.showDetails').click(function(){
			    	$(this).parents('tr').next('.details').toggle('slow');
				});
				$(".details").hide();
				$( "#datepicker" ).datepicker();
			});
		</script>
	</head>
	<body>
	
	<?php 
		include "administrator/db.php";

		$event_query = "select * from event";
		$event_result = mysql_query($event_query) or die(mysql_error());
		
		if($event_result) {
			if(mysql_num_rows($event_result) > 0){
				echo("<table border='1' id=\"my_table\">");
				echo("<thead>");
				echo("<tr><th>Event</th><th>Dato</th><th>Start</th><th>Slut</th><th>Beskrivelse</th></tr>");
				echo("</thead>");
				while($row = mysql_fetch_array($event_result)){
					if($row['isactive'] == true) {
						echo("<tr>");
						echo("<td>" . $row['name'] . "</td>");
						echo("<td>" . $row['event_date'] . "</td>");
						echo("<td>" . $row['time_start'] . "</td>");
						echo("<td>" . $row['time_end'] . "</td>");
						echo("<td>" . $row['description'] . "</td>");
						echo("<td><button class=\"showDetails\">Vis detaljer</button></td>");
						echo("</tr>");
						echo("<tr class=\"details\">");
						echo("<td></td>");
						echo("<td>Fødselsdato: <input type=\"text\" id=\"datepicker\" name=\"date\" /></td>");
						echo("<td>Navn: <input type='text' name='payee_name'/></td>");
						echo("<td>Email: <input type='text' name='payee_email'/></td>");
						echo("<td>Antal billetter: ");
						echo("<select><option value=''>Vælg</option>");
							for( $i = 1; $i < 21; $i++ ) {
								echo("<option value=''>" . $i . "</option>");
							}
						echo("</select></td>");
						echo('<form action="https://secure.quickpay.dk/form/" method="post">
<input type="hidden" name="protocol" value="7" />
<input type="hidden" name="msgtype" value="authorize" />
<input type="hidden" name="merchant" value="86189919" />
<input type="hidden" name="language" value="da" />
<input type="hidden" name="ordernumber" value="1274168351" />
<input type="hidden" name="amount" value="100" />
<input type="hidden" name="currency" value="DKK" />
<input type="hidden" name="continueurl" value="http://quickpay.net/features/payment-window/ok.php" />
<input type="hidden" name="cancelurl" value="http://quickpay.net/features/payment-window/error.php" />
<input type="hidden" name="callbackurl" value="http://quickpay.net/features/payment-window/callback.php" />
<input type="hidden" name="md5check" value="d2259d9db077e0f5a41b4bf271c3c549" />
<input type="submit" value="Åben Quickpay betalingsvindue" /></form>');
						echo("<td><input type='button' value='K&oslash;b' ONCLICK=\"window.location.href='https://secure.quickpay.dk/form/'\"/></td>");
						echo("</tr>");
					}
				}
				echo("</table>");
			}
		}
	?>	
	
	</body>
</html>

<?php
	$html = ob_get_clean();

	// Specify configuration
	$config = array(
    'indent'         => true,
	'output-xhtml'   => true,
	'wrap'           => 200);
           
	// Tidy
	$tidy = new tidy;
	$tidy->parseString($html, $config, 'utf8');
	$tidy->cleanRepair();
	
	echo $tidy;
?>