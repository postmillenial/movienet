<?php

function page_header($title){
    echo '<html><head><title>';
    echo strip_tags($title);
    echo '</title><link type="text/css" rel="stylesheet" href="style.css" media="all" /></head><body>';
    echo '
    <header>
        <span class="headernav">
		<a href="index.php">Main</a>
		<a href="previous.html" onClick="history.back();return false;">Go back</a> ';
    session_start();
    if(isset($_SESSION["Username"]))
        echo '<a href="logout.php">Log out</a>';
    else
        echo '<a href="index.php">Log in</a>';
    echo '</span><h2 class="movienet">Movienet</h2>
        </header>';
    echo "<h1 class='title'>".$title."</h1>";
    echo "<div class='content'>";
}
?>
