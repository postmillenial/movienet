<?php include "header.php"; ?>
<?php
page_header("Upload a Movie Cover Image");
		echo '<form action ="movieImage.php" method="POST" enctype="multipart/form-data" >
		File:
		<input type="file" name="image"> <input type="submit" value="Upload">';
	
		if(isset($_SESSION['Username'])){
			include 'connect.php';
			$file=$_FILES['image']['tmp_name'];
			if(!isset($file)){	
				echo "Please select the movie cover image.";
			}else{
				$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
				$image_name = addslashes($_FILES['image']['name']);
				$image_size = getimagesize($_FILES['image']['tmp_name']);
				echo "<p />";
				if($image_size==FALSE){
					echo "Must choose an image!";
				}else{
					if(!$insert = mysql_query("INSERT INTO movieimage VALUES ('', '$image_name', '$image')")){
						echo "Problem uploading image to DB";
					}else{
						echo "Thanks for adding this movies image! <p />";
						$lastid = mysql_insert_id();
						echo "Image uploaded. <p /> Uploaded Image: <p /> <img src='getImage.php?id=$lastid'/>";
						$img = imagecreatefrompng("firewall.png");
						echo "<img src ='$img'/>";
					}
				}
			}
		}else{
			echo "<p />Movie images will ONLY be excepted from logged in members. Please go to main and log in first.";
		}
	?>

<?php		include "footer.html";	?>

