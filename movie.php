<?php
//movie results page

		include "header.php";		?>
<?php
function no_movie(){
    page_header("Movienet Error");
    echo "No movie specified or bad movie id given.";
}
function get_movie($mid){

    $result = mysql_query("SELECT * FROM movie WHERE m_id = $mid");

    if($result === FALSE)
        die("Movienet Error: ".mysql_error());
    $count = mysql_num_rows($result);
    if($count == 0)
       no_movie();
    return mysql_fetch_array($result);

}
function get_rating(){
    $uid = $_SESSION['uid'];
    $mid = $_GET['mid'];
    $query = mysql_query("SELECT rating FROM userrating
                        WHERE mid = $mid AND uid = $uid");
    if ($query === FALSE)
        return FALSE;
    $count = mysql_num_rows($query);
    if ($count == 0)
        return -1;
    $rating_result = mysql_fetch_array($query);
    return $rating_result['rating'];
}

function update_avg($avg, $count, $old, $new){

        $mid = $_GET['mid'];
        if ($old<0){
        //if there is a rating, but this user hasn't rated, add to avg
            $new_avg = (($avg * $count) + $new ) / ($count + 1);
            $count++;
        } else{
            if ($count == 0){
                echo "Error! Average rating does not exist, but old user rating is present.";
                return FALSE;
            }
            $remove_avg = ((floatval($avg) * $count) - $old);
            $new_avg = ($remove_avg + $new) / $count;
        }
        $query_str = "
            UPDATE movie SET MNet_Rating = $new_avg,
                    Rating_Count = $count
                      WHERE m_id = $mid;";
        $query = mysql_query($query_str);
}
function update_rating($old_rating, $new_rating){
    $uid = $_SESSION['uid'];
    $mid = $_GET['mid'];
    if ($old_rating>=0){
        $query = mysql_query("
            UPDATE userrating SET rating = $new_rating, date = CURDATE()
            WHERE mid = $mid and uid = $uid;
        ");
    } else{
        $query_str = "INSERT INTO userrating VALUES( '$uid', '$mid', '$new_rating', CURDATE() );";
        $query = mysql_query($query_str);
    }
    return $query;
}
if (!isset($_GET['mid']))
    no_movie();
else{
    include 'connect.php';
    $mid = $_GET['mid'];

    $row = get_movie($mid);
    page_header("<a href=movie.php?mid=".$row['M_ID'].">"
            .$row['Title']." (".$row['Year'].")"."</a>");
    $user_rating = get_rating();
    $mnet_rating = $row['MNet_Rating'];
    $num_ratings = $row['Rating_Count'];
    if (isset($_POST['submit'])){

        $new_rating = $_POST['rating'];
        if ($new_rating < 0 || $new_rating > 10)
            die("Invalid rating entered.");
        $success = update_rating($user_rating, $new_rating);
        if (!$success)
            die("Error updating rating: ".mysql_error());
        echo "<p>You just rated this movie ".$_POST['rating']."</p>";
        update_avg($mnet_rating, $num_ratings, $user_rating, $new_rating );
        $row = get_movie($mid);
        $user_rating = get_rating(); //just in case it's been updated
        $mnet_rating = $row['MNet_Rating'];
        $num_ratings = $row['Rating_Count'];
    }
    echo "<h3>".$row['Title']." (".$row['Year'].")"."</h3>";
    echo "<p>Genre: ".$row['Genre']."</p>";
    echo "<p>Country: ".$row['Country']."</p>";
    echo "<p>IMDB Rating: ".$row['IMDB_Rating']."</p>";
    if ($num_ratings > 0){
        echo "<p>Average Rating: ".$mnet_rating."</p>";
        echo "<p>Number of user ratings: ".$num_ratings."</p>";
    } else
        echo "<p>Average Rating: No user ratings found!</p>";
    echo "<form action='movie.php?mid=".$mid."' method='post'>";
    if ($user_rating>0){
        echo "<p>Your Rating: ";
        echo "<input name='rating' type='number' maxlength ='3' value='$user_rating'/>";
        $label = "Update";
    }
    else{
        echo "<p>Your Rating: You haven't rated this movie yet!";
        echo "<input name='rating' type='number' maxlength ='3' />";
        $label = "Submit";
    }

    echo "<input name='submit' type='submit' value='$label'/> </p> </form>";

    $tables = array('directed','produced','acted');
    $role = array('Director','Producer','Actor');

    for ($i=0; $i<count($tables); $i++){

        echo "<p>".$role[$i]."s list: <br />";
        $query = "SELECT Name, x.p_id from person,
            (SELECT p_id from ".$tables[$i]." WHERE m_id = $mid) x
            WHERE person.p_id = x.p_id";

        $result = mysql_query($query);
        if ($result ===FALSE)
           die("Movienet Error: ".mysql_error());

        $count = mysql_num_rows($result);

        if ($count == 0)
           echo "No cast found.</p>";
        else{
            while ($cast = mysql_fetch_array($result)){
                echo "<a href='person.php?pid=".$cast['p_id']."'>".
                    $cast['Name']."</a><br />";
            }
            echo "</p>";
        }
    }
}
?>

<?php			include "footer.html";		?>
