<?php
//movie search page
	include "header.php"; ?>
<?php
include "connect.php";
// Check connection
page_header("Movie Query");

    echo "
	<form action='movie_query.php' method='GET'>
		Enter in any of the following fields to limit search <br />
		Only one parameter can be searched on at a time, parameters above taking priority
		<table>
			<tr>
				<td>Name of movie:</td>
				<td><input type='text' name='movieName' ";
		if (isset($_GET['movieName']))
                  echo "value='".$_GET['movieName']."'";
    echo " /></td>
				</td>
			</tr>

			<tr>
				<td>Name of actor:</td>
				<td><input type='text' name='actorName' ";
                if (isset($_GET['actorName']))
                  echo "value='".$_GET['actorName']."'";
    echo " /></td>
			</tr>

			<tr>
				<td>Movie Year:</td>
				<td><input type='text' name='movieYear' ";
                if (isset($_GET['movieYear']))
                  echo "value='".$_GET['movieYear']."'";
    echo " /></td>
			</tr>

			<tr>
				<td>Genre of Movie:</td>
				<td><input type='text' name='movieGenre' ";
                if (isset($_GET['movieGenre']))
                  echo "value='".$_GET['movieGenre']."'";
    echo " /></td>
			</tr>

			<tr>
				<td>Movie Country:</td>
				<td><input type='text' name='movieCountry' ";
                if (isset($_GET['movieCountry']))
                  echo "value='".$_GET['movieCountry']."'";
    echo " /></td>
			</tr>

		</table>
		<p> <input type='submit' name='submit' value='Search'> </p>
    </form>";



if(isset($_GET['submit'])){
	$submit = $_GET['submit'];
	//srtip will prevent all kind of html attacks
	$actorName = strip_tags($_GET['actorName']);
	$movieName = strip_tags($_GET['movieName']);
	$movieGenre = strip_tags($_GET['movieGenre']);
	$movieYear = strip_tags($_GET['movieYear']);
	$movieCountry = strip_tags($_GET['movieCountry']);
	//$Movie_Date = date($_POST['Movie_Date']);

	if($submit){
		//Check that the password entered is valid
		$movieValid = true;
		if($movieName == ""){
			$movieName ="*";
			$movieValid = false;
		}

		if($movieValid == false && $actorName != ""){

			include 'connect.php';
			$result = mysql_query("
        			SELECT Title,Year,movie.M_ID FROM movie,
            				(SELECT M_ID FROM acted,
                				(SELECT P_ID from person
                	    			WHERE LOWER(Name) = LOWER('$actorName')) p
                			WHERE acted.P_ID = p.P_ID) l
                		WHERE l.M_ID = movie.M_ID ORDER BY Year DESC");
        		if($result === FALSE)
            		die(mysql_error());
			$count = mysql_num_rows($result);
        		if($count == 0)
            			echo "Your search returned no results.";
        		else{
            			echo "<p>Your search for <strong>$actorName's </strong> movies returned $count results:</p>";

            			while($row = mysql_fetch_array($result)){
                			echo "<a href=movie.php?mid=".$row['M_ID'].">".$row['Title']." (".$row['Year'].")"."</a><br />";
            			}
        		}
        	}
        	elseif($movieValid == false && $movieYear != ""){

			include 'connect.php';
			$result = mysql_query("
        			SELECT Title,Year,M_ID FROM movie WHERE Year = $movieYear");
        		if($result === FALSE)
            		die(mysql_error());
			$count = mysql_num_rows($result);
        		if($count == 0)
            			echo "Your search returned no results.";
        		else{
            			echo "<p>Your search for movies in <strong>$movieYear</strong> returned $count results:</p>";

            			while($row = mysql_fetch_array($result)){
                			echo "<a href=movie.php?mid=".$row['M_ID'].">".$row['Title']." (".$row['Year'].")"."</a><br />";
            			}
        		}
        	}
        	elseif($movieValid == false && $movieGenre != ""){

			include 'connect.php';
			$result = mysql_query("
        			SELECT Title,Year,M_ID FROM movie WHERE Genre like \"%$movieGenre%\"");
        		if($result === FALSE)
            		die(mysql_error());
			$count = mysql_num_rows($result);
        		if($count == 0)
            			echo "Your search returned no results.";
        		else{
            			echo "<p>Your search for <strong>$movieGenre</strong> movies returned $count results:</p>";

            			while($row = mysql_fetch_array($result)){
                			echo "<a href=movie.php?mid=".$row['M_ID'].">".$row['Title']." (".$row['Year'].")"."</a><br />";
            			}
        		}
        	}
        	elseif($movieValid == false && $movieCountry != ""){

			include 'connect.php';
			$result = mysql_query("
        			SELECT Title,Year,M_ID FROM movie WHERE Country like \"%$movieCountry%\"");
        		if($result === FALSE)
            		die(mysql_error());
			$count = mysql_num_rows($result);
        		if($count == 0)
            			echo "Your search returned no results.";
        		else{
            			echo "<p>Your search for <strong>$movieCountry's</strong> movies returned $count results:</p>";

            			while($row = mysql_fetch_array($result)){
                			echo "<a href=movie.php?mid=".$row['M_ID'].">".$row['Title']." (".$row['Year'].")"."</a><br />";
            			}
        		}
        	}
        	else{
			include 'connect.php';
			$result = mysql_query("
				SELECT Title, Year, M_ID FROM Movie WHERE Title LIKE \"%$movieName%\"");
			if($result === FALSE)
            		die(mysql_error());
			$count = mysql_num_rows($result);
        		if($count == 0)
            			echo "Your search returned no results.";
        		else{
            			echo "<p>Your search for <strong>$movieName</strong> returned $count results:</p>";

            			while($row = mysql_fetch_array($result)){
                			echo "<a href=movie.php?mid=".$row['M_ID'].">".$row['Title']." (".$row['Year'].")"."</a><br />";
            			}
        		}
        	}
	}
}
?>
		<?php			include "footer.html";		?>
</body>
</html>
