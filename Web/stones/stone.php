<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset='ISO-8859-1'">
		<link rel="stylesheet" type="text/css" href="stones-css.css">
		<script type="text/javascript" src="http://tuerislund.dk/e-nielsen/wp-content/themes/responsive/js/jquery.js"></script>
		<script type="text/javascript" src="http://tuerislund.dk/e-nielsen/wp-content/themes/responsive/js/jquery.innerfade.js"></script>
		<script type="text/javascript">
			$(document) .ready(
				function(){
				  	$('#produkter-index').innerfade({
						speed: 200,
						timeout: 5000,
						type: 'sequence',
						container: '283px'
					});
				  	$('#referencer-index').innerfade({
						speed: 200,
						timeout: 5000,
						type: 'sequence',
						container: '217px'
					});
				  	$('#vedligeholdelse-index').innerfade({
						speed: 200,
						timeout: 5000,
						type: 'sequence',
						container: '220px'
					});
				  	$('#historie-index').innerfade({
						speed: 200,
						timeout: 5000,
						type: 'sequence',
						container: '200x'
					});
				  	$('#nyheder').innerfade({
						speed: 200,
						timeout: 5000,
						type: 'sequence',
						container: '498px'
					});
				  	$('#vedligeholdelse').innerfade({
						speed: 200,
						timeout: 5000,
						type: 'sequence',
						container: '498px'
					});
				  	$('#historie-slide').innerfade({
						speed: 200,
						timeout: 5000,
						type: 'sequence',
						container: '498px'
					});
				  	$('#fakta-slide').innerfade({
						speed: 200,
						timeout: 5000,
						type: 'sequence',
						container: '220px'
					});
					$('#stone-slide').innerfade({
						speed: 200,
						timeout: 5000,
						type: 'sequence',
						container: '500px'
					});
				});
		</script>
	</head>
	<body>

<?php
	try {
		include "db.php";

		if(isset($_GET['name']) && isset($_GET['id'])) {

			$name = mysql_real_escape_string($_GET['name']);
			$id = mysql_real_escape_string($_GET['id']);
	
			$query = "select * from " . $stone_table . " where id = '$id' and name = '$name'";
	
			$result = mysql_query($query);

			echo ("		<div id='midt'>\n");

			if(mysql_num_rows($result) == 1) {
				$data = mysql_fetch_assoc($result);

				$picture_query = "select * from " . $picture_table . " where fk_stone='" . $data['id'] .  "'";
				$picture_result = mysql_query($picture_query);
	
				if(mysql_num_rows($picture_result) > 0) {
					echo ("			<ul id='stone-slide'>\n");
					while($pic_row = mysql_fetch_array($picture_result)) {
						echo ("				<li><img src='images/" . $pic_row['url'] . "' width='500' height='414'/></li>\n");
					}
					echo ("			</ul>\n");
				}
		
				echo ("		</div>\n");
				echo ("		<div id='right'>\n");
	
				$download_query = "select * from " . $download_table . " where fk_stone='" .  $data['id'] . "'";
				$download_result = mysql_query($download_query);
		
				if(mysql_num_rows($download_result) > 0) {
					echo("			<ul id='pdf'>\n");
					while($row=mysql_fetch_array($download_result)) {
						echo("				<li id='download_link'><p><a href=downloads/" . $row['url']. " style='color: #998B7D; font-family: helvetica; text-decoration: none;' target='_blank'>Download</a> " . $row['description'] . "</li>\n");
					}
					echo("			</ul>\n");
				}
				
				echo ("			<h7>" . $data['name'] . "</h7>\n");
				echo ("			<p>" . $data['description'] . "</p>\n");
			}
			echo ("		</div>\n");
		}
	} catch(Exception $e) {
		  echo 'Der er sket en fejl. Kontakt ejeren af siden.';
	}
?>
	</body>
</html>