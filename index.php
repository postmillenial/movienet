<?php			include "header.php";
    page_header('CMSC424 Movienet Home Page');
// unauthenticated login
    if(isset($_SESSION['Username'])){
        echo "<h2>Welcome to Movienet, ".$_SESSION['Name']."!</h2>
        <h2>Logged in as ". $_SESSION['Username']."</h2>
        <p>Proceed to <a href='member.php'>Member</a> page.</p>";
    } else{

        echo "<form action='login.php' method='POST'>
        Username: <input type='text' name='Username' /><br>
        Password: <input type='password' name='Password' /><br>
        <input type='submit' value='Log in' />
        <a href='register.php'>Click</a> here to register.</a>
        </form>";
    }

?>

        <h2>Notes</h2>
        <p>This site is for people all round the world to lookup,
           add, view and rate movies! Register to become a member
           of our movie database community.
        </p>

<?php			include "footer.html";		?>
