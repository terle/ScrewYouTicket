<?php
	$connect = mysql_connect("terle.dk", "ticketsAdmin", "minpikerhaard");
	mysql_select_db("screwyouticket", $connect);

	$address_table = "address";
	$event_table = "event";
	$event_images_table = "event_images";
	$payment_table = "payment";
	$payment_system_codes_table = "payment_system_codes";
	$price_table = "price";
	$ticket_table = "ticket";
?>