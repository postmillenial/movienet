<?php			include "header.php"; ?>

<?php

if(isset($_SESSION['Username'])){
    page_header("Already logged in.");
    echo "You're already logged in! Please <a href='logout.php'>log out</a> first to login again. <a href='index.php'>Back to home page</a>";
} else if(!isset($_POST['Username']) || !isset($_POST['Password'])){
    page_header("Login Failed.");

    echo "Credentials incomplete; please login at <a href='index.php'>home page</a>.";
} else{
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    if($Username && $Password)
    {
        include 'connect.php';
        
        $query = mysql_query("SELECT * FROM user WHERE lower(Username)=lower('$Username')");
        $numrows = mysql_num_rows($query);
        
        if($numrows !=0){
                //Start loging/Password check as user exists in DB!!!
                while($row = mysql_fetch_assoc($query)){
                    $db_user_Name = $row['Name']; 
                    $db_user_Username = $row['Username'];  
                    $db_user_Password = $row['Password']; 
                    $uid = $row['UserID'];
                }
                // Check if a username and password match database 
                if(strtolower($Username) == strtolower($db_user_Username)
                         && md5($Password) == $db_user_Password){
                    page_header("Login successful!");
                    echo "Login Successful! <a href='member.php'> Click here </a> to enter the members page.";
                    $_SESSION['Username']=$db_user_Username;	
                    $_SESSION['Name']=$db_user_Name;
                    $_SESSION['uid'] = $uid;
                }else{
                    page_header("Incorrect Password");
                    echo "Incorrect Password <br />"; 
                }
        }else{
            page_header("Login failed");
            echo "Username does not exist in database!";
        }
    }else{
        page_header("Login failed");
        echo "You must enter both a username and Password.";
    }
}
?>

<?php			include "footer.html"; ?>

