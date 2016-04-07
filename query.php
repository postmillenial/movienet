<?php
include "header.php";
include "connect.php";
// Check connection

page_header("Query Page");

if(isset($_POST['submit'])){
	$submit = $_POST['submit'];
	//srtip will prevent all kind of html attacks
	$Name = strip_tags($_POST['Name']);
	$Username = strip_tags($_POST['Username']);
	$Email = strip_tags($_POST['Email']);
	$Sex = strip_tags($_POST['Sex']);	
	$Birthday = date($_POST['Birthday']);
	$Password =  strip_tags($_POST['Password']);
	$Repeat_Password =  strip_tags($_POST['Repeat_Password']);	
	$Date = date("Y-m-d");
	//all passwords will be md5 encripted so even people with 
	//access to the db wont be able to login as someone else without
	//break md5 encription!
	
	if($submit){		
		//Check that the password entered is valid
		if($Name && $Email && $Sex && $Birthday && $Password && $Repeat_Password){
			if(strlen($Name)>25||strlen($Name)<4){
				echo "Name must have 4-25 characters! Please Try again.";
			}else if(strlen($Username)>25||strlen($Username)<4){
				echo "Username must have 4-25 characters! Please Try again.";
			}else if(strlen($Email)>25||strlen($Email)<4){
				echo "Email must have 4-25 characters! Please Try again.";
			}else if($Sex != 'M' && $Sex != 'F'){
				echo "Sex must be either M for male or F for female! Please Try again. Thanks.";
			}else if(strlen($Email)>25 || strlen($Password)<4){
				echo "Password must have 4-25 characters! Please Try again.";
			}else if($Password != $Repeat_Password){
				echo "Password must match Repeat Password! Please Try again.";
			}else{	
			//Register the user
				include 'connect.php';
				
				//check if user name already exists!!!!!!
					$checkUserNameQuery = mysql_query("SELECT Username FROM user WHERE Username='$Username'");
					$count = mysql_num_rows($checkUserNameQuery);
				if($count != 0){
					 echo("Sorry, Username already taken. Please try another one.");
				}else{
					//Encripes Password before saving it into database!
					$Password =  md5(strip_tags($_POST['Password']));
					$Repeat_Password =  md5(strip_tags($_POST['Repeat_Password']));		
					
					$query = mysql_query("
						INSERT INTO user VALUES('', '$Username', '$Name', '$Email', '$Sex', '$Birthday','$Password', '$Date');
					");	
					die("Congratulations! You are now a registered Movienet Users! <a href='index.php'> Click </a> here to return to login and get started");
				}
			}
		}else{
			echo "You must fill out all fields!";
		}
	}
}
?>
	<form action='query.php' method='POST'>
		Enter in any of the following fields to limit search 
		<table>
			<tr>
				<td>Name of actor:</td> 
				<td><input type='text' name='Actor_name'</td> 
			</tr>	
			<tr>
				<td>Name of movie:</td>
				<td><input type='text' name='Movie_name'</td> 
			</tr>	
		</table>
		<p> <input type='submit' name='submit' value='Register'> </p>
<?php
//if(){
//}
$result = mysql_query("SELECT Name FROM person LIMIT 5");

while($row = mysql_fetch_array($result)){
	echo $row['Name'];
	echo "<br>";
}
?>
<?php include "footer.html"; ?>

