<?php
include "header.php";
    page_header("Profile Update");
if(!isset($_SESSION['Username'])){
    echo "You must log in to view this page.";
}else{ 
    echo "Welcome, ".$_SESSION['Name'], " to your Movienet Home Page! ";
    if(isset($_POST['submit'])){
        $submit = $_POST['submit'];
        $Username = $_SESSION['Username'];
        $Name = strip_tags($_POST['Name']);
        $Email = strip_tags($_POST['Email']);
        $Sex = strip_tags($_POST['Sex']);	
        $Birthday = date($_POST['Birthday']);
        
        if($submit){	
            //Check that the password entered is valid
            if($Name && $Email && $Sex && $Birthday){
                if(strlen($Name)>25||strlen($Name)<4){
                    echo "Name must have 4-25 characters! Please Try again.";
                }else if(strlen($Email)>25||strlen($Email)<4){
                    echo "Email must have 4-25 characters! Please Try again.";
                }else if($Sex != 'M' && $Sex != 'F'){
                    echo "Sex must be either M for male or F for female! Please Try again. Thanks.";
                }
                else{	
                //Register the user
                    include 'connect.php';
                    
                        $query = mysql_query("
                            UPDATE user SET 
                            Name = '$Name',
                            Email = '$Email',
                            Sex = '$Sex', 
                            Birthday = '$Birthday'
                            WHERE LOWER(Username) = LOWER('$Username')
                        ");	
                        echo "Profile updated. <a href='user.php'>Return to user profile</a>";
                    }
            }else{
                echo "You must fill out all fields!";
            }
        }
    }
}
?>

<?php       include "footer.html";           ?>


