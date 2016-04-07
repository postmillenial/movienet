<?php

// logged in home page

   include "header.php"; ?>
<?php
    page_header("Member Home Page");
    if(isset($_SESSION['Username'])){
        echo "<p class='welcome'>Welcome, ".$_SESSION['Name'], " to your Movienet Home Page!</p>";
        echo '<h5>Fast Links</h5>
        <nav>
            <ol>
                <li><a href="user.php">User</a></li>
                <li><a href="movie_query.php">Movie Query</a></li>
                <li><a href="actor_query.php">Actor Query</a></li>
                <li><a href="director_query.php">Director Query</a></li>
                <li><a href="producer_query.php">Producer Query</a></li>
                <li><a href="award_query.php">Award Query</a></li>
                <li><a href="custom_query.php">General Query</a></li>
                <li><a href="movieImage.php">Add Movie Image</a></li>
                <li><a href="contact.php">Contact us</a></li>
            </ol>
        </nav>';
    } else{
        echo "You must log in to view this page.";
    }
?>
<?php			include "footer.html";		?>
