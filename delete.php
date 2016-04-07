<?php
// Delete a user profile

		include "header.php"; ?>
<!-- Delete a user profile -->
<?php

page_header('Movienet Profile Delete');

if(!isset($_SESSION['Username'])){
    die("You must log in to view this page.");
} else if (!isset($_POST['confirm'])){
    echo "Are you sure you want to delete the account for the username: <strong>".$_SESSION['Name'], "</strong>?";
    echo "<form action='delete.php' method='POST'>

          <p>Enter your password to confirm:</p>
          <p><input type='password' name='password'>
          <input type='submit' name='confirm' value='Delete Profile'></p>
          </form>";
} else{
    //Check that the password entered is valid
    if($pw = $_POST['password']){
    //Register the user
        include 'connect.php';
        $uid = $_SESSION['uid'];
        $query = mysql_query("SELECT * FROM user WHERE UserID= $uid");

        if($query === FALSE) {
            echo mysql_error();
        }
        else{
            $numrows = mysql_num_rows($query);
            if($numrows == 1){
                //Start loging/Password check as user exists in DB!!!
                $row = mysql_fetch_assoc($query);
                $db_pw = $row['Password'];

                // Check if a username and password match database
                if(md5($pw) == $db_pw){
                    $output = implode($row, ",") ."\n";
                    $query = mysql_query("SELECT mid,rating FROM userrating WHERE uid = $uid");
                    while ($row = mysql_fetch_assoc($query)){
                        $output .= implode($row , ",")."\n";
                    }
                    $username = $_SESSION['Username'];
                    $writeRes = file_put_contents( "log/".$uid.".".$username, $output);
                    $query = mysql_query("DELETE FROM userrating WHERE uid = $uid");
                    $query = mysql_query("DELETE FROM user WHERE lower(Username)=lower('$username')");
                    if($query === FALSE) {
                        echo mysql_error();
                    }else{
                        session_destroy();
                        echo "Your account has been deleted and logged to a file.";
                    }
                }else{
                    echo "Incorrect password.";
                }
            }else{
                echo "SQL Error- couldn't find account.";
            }
        }
    }else{
        echo "Incorrect (empty) password.";
    }
}
?>
<?php include "footer.html"; ?>
