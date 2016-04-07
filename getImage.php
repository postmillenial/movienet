<?php

//separate code just to load an image from the page lol
	include 'connect.php';

	$id=addslashes($_REQUEST['id']);

	if(!$image = mysql_query("SELECT * FROM movieNet.movieimage WHERE id='$MovieId'")){
		echo "Cant load image from DB";
	}else{
		//gets array of returned query
		$image = mysql_fetch_assoc($image);
		$image = $image['Image'];

		header("Content-type: image/jpeg");
		echo $image;

	}
?>
