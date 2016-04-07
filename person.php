<?php			include "header.php"; ?>
<?php
function no_actor(){
    page_header("Movienet Error");
    echo "No actor specified or bad actor id given.";
}

if (!isset($_GET['pid']))
    no_actor();
else{
    $pid = $_GET['pid'];
    include 'connect.php';		
    $result = mysql_query("SELECT * FROM person WHERE p_id = $pid");

    if($result === FALSE)
        die("Movienet Error: ".mysql_error());
    $count = mysql_num_rows($result);
    if($count == 0)
       no_actor(); 
    $row = mysql_fetch_array($result);

    page_header("<a href=person.php?pid=".$row['P_ID'].">".$row['Name']."</a> (Person)");
    echo "<p>Movies Acted in: <br />";
    $result = mysql_query("SELECT Year, Title, x.M_ID from movie, 
        (SELECT m_id from acted WHERE p_id = $pid) x
        WHERE movie.m_id = x.m_id ORDER BY Year DESC"); 
    if ($result ===FALSE)
       die("Movienet Error: ".mysql_error());
    $count = mysql_num_rows($result);
    if ($count == 0)
       echo "No movies found.</p>";
    else{
        while ($cast = mysql_fetch_array($result)){
            echo "<a href='movie.php?mid=".$cast['M_ID']."'>"
                        .$cast['Title']." (".$cast['Year'].")</a><br />";
        }
        echo "</p>";
    } 
    
    echo "<p>Movies Directed: <br />";
    $result = mysql_query("SELECT Year, Title, x.M_ID from movie, 
        (SELECT m_id from directed WHERE p_id = $pid) x
        WHERE movie.m_id = x.m_id ORDER BY Year DESC"); 
    if ($result ===FALSE)
       die("Movienet Error: ".mysql_error());
    $count = mysql_num_rows($result);
    if ($count == 0)
       echo "No movies found.</p>";
    else{
        while ($cast = mysql_fetch_array($result)){
            echo "<a href='movie.php?mid=".$cast['M_ID']."'>"
                        .$cast['Title']." (".$cast['Year'].")</a><br />";
        }
        echo "</p>";
    } 
    
    echo "<p>Movies Produced: <br />";
    $result = mysql_query("SELECT Year, Title, x.M_ID from movie, 
        (SELECT m_id from produced WHERE p_id = $pid) x
        WHERE movie.m_id = x.m_id ORDER BY Year DESC"); 
    if ($result ===FALSE)
       die("Movienet Error: ".mysql_error());
    $count = mysql_num_rows($result);
    if ($count == 0)
       echo "No movies found.</p>";
    else{
        while ($cast = mysql_fetch_array($result)){
            echo "<a href='movie.php?mid=".$cast['M_ID']."'>"
                        .$cast['Title']." (".$cast['Year'].")</a><br />";
        }
        echo "</p>";
    } 
}
?>

<?php			include "footer.html";		?>
