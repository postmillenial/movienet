<?php
// Advanced queries.
			include "header.php";
include "connect.php";
// Check connection
page_header('Custom Query');
echo "<p>
<form action='custom_query.php' method='POST'>
	<!--Section 1-->
		1) Search for:";
			if (isset($_POST['searchFor'])){
				echo "<strong>";
				echo $_POST['searchFor'];
				echo "</strong>";
				echo "<input type='submit' name='submit' value='Reset'>";
			}else{
				echo "
					<select input type='option' name='searchFor'>
							<option value ='-----'>-----</option>
							<option value ='Actor(s)'>Actor(s)</option>
							<option value ='Award(s)'>Award(s)</option>
							<option value ='Director(s)'>Director(s)</option>
							<option value ='Movie(s)'>Movie(s)</option>
							<option value ='Movie Image(s)'>Movie Image(s)</option>
							<option value ='Movie Nomination(s)'>Movie Nomination(s)</option>
							<option value ='Person(s)'>Person(s)</option>
							<option value ='Person Nomination(s)'>Person Nomination(s)</option>
							<option value ='Producer(s)>Producer(s)</option>
							<option value ='User(s)'>User(s)</option>
					</select>
					<input type='submit' name='submit' value='Go'>
				";
			}echo "
	<br>
	<br>
</form>";


if(isset($_POST['submit'])){
	if (isset($_POST['searchFor'])){
		$searchFor = strip_tags($_POST['searchFor']);
		switch($searchFor){
		case "Actor(s)":
			echo "
			<form action='display_actor.php' method='POST'>
				<!--Section 2-->
				2) Pick what fields you want displayed:
					<select input type='option' Name='display'>
								<option value = '*' >All</option>
								<option value ='Name'>Name(s)</option>
					</select>
				<br >
				<br >

				<!--Section 3-->
					3) Enter in any of the following fields to limit your search.<br> <br>
					<span class='tab'></span>
						by Actor Name:
							<input type='text' name='Name'";
								if (isset($_POST['Name']))
									echo "value='".$_POST['Name']."'";
								else{
									echo "value =''";
								}
								echo" />
							<input type ='radio'  name='whereNameEqualsConstraint' value='Incudes'/> Includes
							<input type ='radio'  name='whereNameEqualsConstraint' value='Exact'/> Exact
					<br>
					<br>

					<span class='tab'></span>
						by Movie Title:
							<input type='text' name='Title'";
								if (isset($_POST['Title']))
									echo "value='".$_POST['Title']."'";
								else{
									echo "value =''";
								}
								echo" />
							<input type ='radio'  name='whereNameEqualsConstraint' value='Incudes'/> Includes
							<input type ='radio'  name='whereNameEqualsConstraint' value='Exact'/> Exact
					<br>

					<br>

					<span class='tab'></span>
						by genre:
							<select input type='option' name='genreConsraint'>
								<option value ='Action'>Action</option>
								<option value ='Drama'>Drama</option>
								<option value ='Adventure'>Adventure</option>
								<option value ='Mystery'>Mystery</option>
							</select>
							NEED TO ADD TO QUERY
					<br>
					<br>


				<br>
				<br>
				<br>
				<br>



				<br>
				<br>
				<br>
				<br>


				<p> <input type='submit' name='submit' value='Search'> </p>
				</form>


				";



		break;
		case "acted":
		break;
		}
	}
}
?>
<?php			include "footer.html";		?>
