<?php
// Award result page.


include "header.php"; ?>
<?php
function no_award(){
    page_header("Movienet Error");
    echo "No award specified or bad award id given.";
}

if (!isset($_GET['aid']))
    no_award();
else{
    $aid = $_GET['aid'];
    include 'connect.php';
    $result = mysql_query("SELECT * FROM award WHERE a_id = $aid");

    if($result === FALSE)
        die("Movienet Error: ".mysql_error());
    $count = mysql_num_rows($result);
    if($count == 0)
       no_award();
    else{
    $row = mysql_fetch_array($result);

    page_header("<a href=award.php?aid=".$row['A_ID'].">".$row['Category']." ("
        .$row['Year'].")</a> (Award)");
    echo "<h3>".$row['Category']." (".$row['Year'].") </h3>";
    $result = mysql_query(" SELECT movie.m_id,p_id,title,name,won from movie,
                (SELECT m_id,p_id,name,z.won from movienomination,
                (SELECT mn_id, p_id,name,won from awardsassociation,
                 (SELECT pn_id, x.p_id,name, won FROM person,
                    (SELECT * FROM personnomination
                     WHERE a_id = $aid) x
                 WHERE x.p_id = person.p_id) y
                WHERE y.pn_id = awardsassociation.pn_id) z
                WHERE z.mn_id = movienomination.mn_id) a WHERE a.m_id = movie.m_id
                ORDER BY won DESC
            ;");
    if ($result ===FALSE)
        die("Movienet Error: ".mysql_error());
    else{
        echo "<p>Nominations: (* = Winner)<br />";
        echo "<ul>";
        while($row = mysql_fetch_assoc($result)){
            echo "<li>";
            $won = $row['won'];
            if ($won) echo "<strong>";
            echo '<a href="movie.php?mid='.$row['m_id'].'">';
            echo $row['title']."</a> - ";
            echo '<a href="person.php?pid='.$row['p_id'].'">';
            echo $row['name']."</a>";
            if ($won) echo "</strong> *";
            echo "</li>";
        }
        echo "</ul></p>";
    }
    }
}
?>

<?php			include "footer.html";		?>
