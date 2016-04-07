<?php   include "header.php";
include "connect.php";
// Check connection
page_header("Producer Query");
echo "
	<form action='producer_query.php' method='GET'>
		Enter in any of the following fields to limit search 
		<table>
			<tr>
				<td>Name of producer:</td> 
				<td><input type='text' name='producerName' ";
                if (isset($_GET['producerName']))
                  echo "value='".$_GET['producerName']."'";
        echo" /></td> 
			</tr>	
		</table>
		<p> <input type='submit' name='submit' value='Search'> </p>
    </form>";

if(isset($_GET['submit'])){
	$submit = $_GET['submit'];
	//srtip will prevent all kind of html attacks
    $producerName= strip_tags($_GET['producerName']);
	//$Movie_Date = date($_POST['Movie_Date']);
	
	if($submit){		
		//Check that the password entered is valid
		
		if($producerName == "")
			$producerName ="*";

		include 'connect.php';		
		$result = mysql_query("
			SELECT DISTINCT PAlias.P_ID,Name 
				FROM Produced INNER JOIN 
					(SELECT Name,P_ID FROM Person WHERE Name LIKE \"%$producerName%\") AS PAlias 
				ON Produced.P_ID = PAlias.P_ID"); 
        if($result === FALSE)
            die("Movienet Error: ".mysql_error());
		$count = mysql_num_rows($result);
        if($count == 0)
            echo "Your search returned no results.";
        else{
            echo "<p>Your search for <strong>$producerName</strong> returned $count results:</p>";

            while($row = mysql_fetch_array($result)){
                echo "<a href=person.php?pid=".$row['P_ID'].">".$row['Name']."</a><br />";
            }
        }
	}
}
?>
<?php			include "footer.html";		?>

