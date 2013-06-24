<html>
	<head>
	</head>
	<body>
		<form name="form" action="" method="post" enctype="multipart/form-data">
			Name <input type="text" name="name" /></br>
			Photo <input type="file" name="file" />
			<input type="submit" name="submit" value="submit" /> 
			<img src="../images/head.jpg" />
		</form>
	</body>
</html>

<?php

$image_folder = "../images/";

if ($_FILES["file"]["error"] > 0) {
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
} else {
	echo "Name: " . $_POST['name'] . "</br>";
	echo "Upload: " . $_FILES["file"]["name"] . "<br>";
	echo "Type: " . $_FILES["file"]["type"] . "<br>";
	echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
	echo "Stored in: " . $_FILES["file"]["tmp_name"];
  
//	if (file_exists($image_folder . $_FILES["file"]["name"])) {
	//	echo $_FILES["file"]["name"] . " already exists. ";
//	} else {
		move_uploaded_file($_FILES["file"]["tmp_name"], $image_folder . $_FILES["file"]["name"]);
		echo "Stored in: " . "../images/" . $_FILES["file"]["name"];
//	}
}
?>