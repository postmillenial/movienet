<?php
	$connect = mysql_connect("localhost", "root","") or die ("Couldnt Connect");
	mysql_select_db("movieNet") or die ("Couldnt Find DB");
?>