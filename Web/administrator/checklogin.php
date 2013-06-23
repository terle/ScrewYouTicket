<?php
	session_start();
	$hardcodedusername = "admin";
	$hardcodedpassword = "password";

	// username and password sent from form 
	$myusername=$_POST["myusername"]; 
	$mypassword=$_POST["mypassword"]; 

	// To protect MySQL injection (more detail about MySQL injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);

	// If result matched $myusername and $mypassword, table row must be 1 row
	if(strcmp($hardcodedusername, $myusername) == 0 && strcmp($hardcodedpassword, $mypassword) == 0) {
		// Register $myusername, $mypassword and redirect to file "login_success.php"
		session_register("myusername");
		session_register("mypassword");
		$_SESSION['timeout'] = time();
		header("location:index.php");
		echo mysql_error();
	} else {
		echo "<center><font style='color: red;'>Forkert brugernavn eller kodeord</font></center>";
		echo "<center><a href='login.php'>Log p&aring;</a></center>";
	}
?>