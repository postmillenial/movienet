<?php   include "header.php";
include "connect.php";
// Check connection
page_header("Director Query");
echo "
	<form action='director_query.php' method='GET'>
		Enter in any of the following fields to limit search 
		<table>
			<tr>
				<td>Name of director:</td> 
				<td><input type='text' name='directorName' ";
                if (isset($_GET['directorName']))
                  echo "value='".$_GET['directorName']."'";
        echo" /></td> 
			</tr>	
		</table>
		<p> <input type='submit' name='submit' value='Search'> </p>
    </form>";

if(isset($_GET['submit'])){
	$submit = $_GET['submit'];
	//srtip will prevent all kind of html attacks
	$directorName = strip_tags($_GET['directorName']);
	//$Movie_Date = date($_POST['Movie_Date']);
	
	if($submit){		
		//Check that the password entered is valid
		
		if($directorName == "")
			$directorName ="*";

		include 'connect.php';		
		$result = mysql_query("
			SELECT DISTINCT PAlias.P_ID,Name 
				FROM Directed INNER JOIN 
					(SELECT Name,P_ID FROM Person WHERE Name LIKE \"%$directorName%\") AS PAlias 
				ON Directed.P_ID = PAlias.P_ID"); 
        if($result === FALSE)
            die("Movienet Error: ".mysql_error());
		$count = mysql_num_rows($result);
        if($count == 0)
            echo "Your search returned no results.";
        else{
            echo "<p>Your search for <strong>$directorName</strong> returned $count results:</p>";

            while($row = mysql_fetch_array($result)){
                echo "<a href=person.php?pid=".$row['P_ID'].">".$row['Name']."</a><br />";
            }
        }
	}
}
?>
<?php			include "footer.html";		?>

