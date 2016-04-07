<?php   include "header.php";
include "connect.php";
// Check connection
page_header("Actor Query");
echo "
	<form action='actor_query.php' method='GET'>
		Enter in any of the following fields to limit search 
		<table>
			<tr>
				<td>Name of actor:</td> 
				<td><input type='text' name='actorName' ";
                if (isset($_GET['actorName']))
                  echo "value='".$_GET['actorName']."'";
        echo" /></td> 
			</tr>	
		</table>
		<p> <input type='submit' name='submit' value='Search'> </p>
    </form>";

if(isset($_GET['submit'])){
	$submit = $_GET['submit'];
	//srtip will prevent all kind of html attacks
	$actorName = strip_tags($_GET['actorName']);
	//$Movie_Date = date($_POST['Movie_Date']);
	
	if($submit){		
		//Check that the password entered is valid
		
		if($actorName == "")
			$actorName ="*";

		include 'connect.php';		
		$result = mysql_query("
			SELECT DISTINCT PAlias.P_ID,Name 
				FROM Acted INNER JOIN 
					(SELECT Name,P_ID FROM Person WHERE Name LIKE \"%$actorName%\") AS PAlias 
				ON Acted.P_ID = PAlias.P_ID"); 
        if($result === FALSE)
            die("Movienet Error: ".mysql_error());
		$count = mysql_num_rows($result);
        if($count == 0)
            echo "Your search returned no results.";
        else{
            echo "<p>Your search for <strong>$actorName</strong> returned $count results:</p>";

            while($row = mysql_fetch_array($result)){
                echo "<a href=person.php?pid=".$row['P_ID'].">".$row['Name']."</a><br />";
            }
        }
	}
}
?>
<?php			include "footer.html";		?>

