<?php    include "header.php";

    page_header("User Profile");

    if(isset($_SESSION['Username'])){
        echo "<p class='welcome'>Welcome, ".$_SESSION['Name']. ", to your Movienet User Profile!</p> <br />";
    }else{
        die("You must log in to view this page.");
    }
    $username = $_SESSION['Username'];
    include 'connect.php';
    $userQuery = mysql_query("SELECT * FROM user WHERE LOWER(Username)=LOWER('$username')");

    if($userQuery === FALSE) {
        die(mysql_error()); // TODO: better error handling
    }

    $count = mysql_num_rows($userQuery);
    if($count == 0){
        die("User profile not found.");
    }else{

        while($row = mysql_fetch_assoc($userQuery)){    
            $name = $row['Name']; 
            $username = $row['Username'];  
            $email = $row['Email']; 
            $sex = $row['Sex'];
            $birthday = $row['Birthday'];
        }

    }
?>
<form action='update_user.php' method='POST'>
    <table>
        <tr><td><h4>Update Profile</h4></td></tr>
        <tr>
            <td>Username:</td><td><?php echo $_SESSION['Username'];?></td> 
        </tr>   
        <tr>
            <td>Full name:</td> 
            <?php 
            if(!isset($_POST['submit'])){ 
                $Name = "";
            }
            ?>
            <td>
        <input type='text' name='Name' value='<?php echo $_SESSION["Name"];?>'></td> 
        </tr>   
        <tr>
            <td>Email:</td> 
            <td><input type='text' name='Email' value='<?php echo $email;?>'></td>
        </tr>
        <tr>
            <td>Sex (M or F):</td> 
            <?php 
            if(!isset($_POST['submit'])){ 
                $Sex = "";
            }
            ?>
            <td>
        <input type ='radio' name='Sex' value='M'
         <?php if($sex=='M') echo 'checked=true';?>/> Male
        <input type ='radio' name='Sex' value='F'
         <?php if($sex=='F') echo 'checked=true';?>/> Female
            </td>

        </tr>
        <tr>
            <td>Birthday:</td> 
            <?php 
            if(!isset($_POST['submit'])){ 
                $Birthday = "";
            }
            ?>
            <td><input type='date' name='Birthday' value='<?php echo $birthday;?>'></td>
        </tr>
    </table>
    <p>Ratings: <br />
    <?php
        $uid = $_SESSION['uid'];
        $query = mysql_query(" SELECT title, mid, rating from movie,
            (SELECT mid,rating FROM userrating WHERE uid = $uid) x
            WHERE m_id = mid;
        ");
        while ($row = mysql_fetch_assoc($query)){
            echo "<a href='movie.php?mid=".$row['mid']."'>";
            echo $row['title'];
            echo "</a>";
            echo " (".$row['rating'].")"."<br />";
        }
        
    ?>
    </p>
    <p> <input type='submit' name='submit' value='Update'> </p>
</form>

<form action='delete.php' method='POST'>
    <p> <input type='submit' name='submit' value='Delete Profile'> </p>
</form>

</div>
<?php			include "footer.html";		?>
</body>
</html>
