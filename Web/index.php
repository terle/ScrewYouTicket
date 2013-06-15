<?php
	session_start();
	if(!session_is_registered(myusername)){
		header("location:login.php");
	} else {
		header("location:stones.php");
	}
?>