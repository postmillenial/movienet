<?php			include "header.php"; 
include "connect.php";
// Check connection
page_header("Award Query");

    echo "
	<form action='award_query.php' method='GET'>
		Enter in any of the following fields to limit search <br />
		Only one parameter can be searched on at a time, parameters above taking priority
		<table>
			<tr>
				<td>Name of Person:</td> 
				<td><input type='text' name='personName' ";
                if (isset($_GET['personName']))
                  echo "value='".$_GET['personName']."'";
    echo " /></td> 
			</tr>	
			<tr>
				<td>Name of Movie:</td>
				<td><input type='text' name='movieName' ";
		if (isset($_GET['movieName']))
                  echo "value='".$_GET['movieName']."'";
    echo " /></td> 
			
			<tr>
				<td>Award Category:</td> 
				<td><input type='text' name='awardCategory' ";
                if (isset($_GET['awardCategory']))
                  echo "value='".$_GET['awardCategory']."'";
    echo " /></td> 
			</tr>
			
			<tr>
				<td>Award Year:</td> 
				<td><input type='text' name='awardYear' ";
                if (isset($_GET['awardYear']))
                  echo "value='".$_GET['awardYear']."'";
    echo " /></td> 
			</tr>	
				
			</tr>	
		</table>
		<p> <input type='submit' name='submit' value='Search'> </p>
    </form>";
    
if(isset($_GET['submit'])){
	
	$submit = $_GET['submit'];
	//strip will prevent all kind of html attacks
	$personName = strip_tags($_GET['personName']);
	$movieName = strip_tags($_GET['movieName']);
	$awardCategory = strip_tags($_GET['awardCategory']);
	$awardYear = strip_tags($_GET['awardYear']);
	//$Movie_Date = date($_POST['Movie_Date']);
	
	if($submit){	
		//Check that the password entered is valid
		
		$validPerson = true;
		if($personName == "")
		{
			$personName ="*";
			$validPerson = false;
		}
		if($movieName != "" && $validPerson == false){
			include 'connect.php';		
			$result = mysql_query("
        			SELECT Title,Category,Year,Won,Award.A_ID
					FROM Award INNER JOIN 
						(Select A_ID,Title,Won from MovieNomination INNER JOIN 
							(Select M_ID,Title from Movie where Title like \"%$movieName%\")
                					as MAlias 
                				on MAlias.M_ID = MovieNomination.M_ID )
        					as NomAlias
        				on Award.A_ID = NomAlias.A_ID");
        
        		if($result === FALSE)
            			die("Movienet Error: ".mysql_error());
			$count = mysql_num_rows($result);
        		if($count == 0)
            			echo "Your search returned no results.";
        		else{
            			echo "<p>Your search for <strong>$movieName's</strong> awards returned $count results:</p>";

            			while($row = mysql_fetch_array($result)){
                		//echo "<a href=movie.php?mid=".$row['M_ID'].">".$row['Title']." (".$row['Year'].")"."</a><br />";
                		if ($row['Won'] == 1)
                			echo "<a href=award.php?aid=".$row['A_ID'].">".$row['Title']." won ".$row['Category']." in ".$row['Year']."</a><br />";
                		else
                			echo "<a href=award.php?aid=".$row['A_ID'].">".$row['Title']." was nominated for ".$row['Category']." in ".$row['Year']."</a><br />";
            			}
            		}
		}
		elseif($awardCategory != "" && $validPerson == false){
			include 'connect.php';		
			$result = mysql_query("
        			SELECT Category,Year,A_ID FROM Award Where Category like \"%$awardCategory%\"");
        
        		if($result === FALSE)
            			die("Movienet Error: ".mysql_error());
			$count = mysql_num_rows($result);
        		if($count == 0)
            			echo "Your search returned no results.";
        		else{
            			echo "<p>Your search for awards of <strong>$awardCategory</strong> category returned $count results:</p>";

            			while($row = mysql_fetch_array($result)){
                		//echo "<a href=movie.php?mid=".$row['M_ID'].">".$row['Title']." (".$row['Year'].")"."</a><br />";
                		echo "<a href=award.php?aid=".$row['A_ID'].">".$row['Category']." (".$row['Year'].")</a><br />";
                		}
            		}
		}
		elseif($awardYear != "" && $validPerson == false){
			include 'connect.php';		
			$result = mysql_query("
        			SELECT Category,Year,A_ID FROM Award Where Year = $awardYear");
        
        		if($result === FALSE)
            			die("Movienet Error: ".mysql_error());
			$count = mysql_num_rows($result);
        		if($count == 0)
            			echo "Your search returned no results.";
        		else{
            			echo "<p>Your search for awards in <strong>$awardCategory</strong> returned $count results:</p>";

            			while($row = mysql_fetch_array($result)){
                		//echo "<a href=movie.php?mid=".$row['M_ID'].">".$row['Title']." (".$row['Year'].")"."</a><br />";
                		echo "<a href=award.php?aid=".$row['A_ID'].">".$row['Category']." (".$row['Year'].")</a><br />";
                		}
            		}
		}
		else {
			include 'connect.php';		
			$result = mysql_query("
        			SELECT Name,Category,Year,Won,Award.A_ID
					FROM Award INNER JOIN 
						(Select A_ID,Name,Won from PersonNomination INNER JOIN 
							(Select P_ID,Name from Person where Name like \"%$personName%\")
                					as PAlias 
                				on PAlias.P_ID = PersonNomination.P_ID )
        					as NomAlias
        				on Award.A_ID = NomAlias.A_ID");
        
        		if($result === FALSE)
            			die("Movienet Error: ".mysql_error());
			$count = mysql_num_rows($result);
        		if($count == 0)
            			echo "Your search returned no results.";
        		else{
            			echo "<p>Your search for <strong>$personName's</strong> awards returned $count results:</p>";

            			while($row = mysql_fetch_array($result)){
                		//echo "<a href=movie.php?mid=".$row['M_ID'].">".$row['Title']." (".$row['Year'].")"."</a><br />";
                		if ($row['Won'] == 1)
                			echo "<a href=award.php?aid=".$row['A_ID'].">".$row['Name']." won ".$row['Category']." in ".$row['Year']."</a><br />";
                		else
                			echo "<a href=award.php?aid=".$row['A_ID'].">".$row['Name']." was nominated for ".$row['Category']." in ".$row['Year']."</a><br />";
                		}
            		}
        	}
        }
}
?>

<?php			include "footer.html";		?>
