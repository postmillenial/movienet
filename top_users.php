<?php include "header.php";
    page_header("DVD Award");
?>
    <p>
        The following are this month's top rating users! Congratulations for winning the DVD award!
    </p>

<?
    include connect.php
    $query "SELECT username from user, 
            (SELECT uid, count(uid) FROM userrating 
            WHERE date > DATE_SUB(CURDATE(), INTERVAL 1 MONTH) 
            GROUP BY uid ORDER BY count(uid) DESC LIMIT 3) x where x.uid = user.uid;"
    $result = mysql_query($query);
    $count = mysql_num_rows($result);
    echo "<li>";
    for ($i = 0; $i<$count; $i++){
        
    }
?>
<?php include "footer.html"; ?>
