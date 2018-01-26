<?php
/*
Group 13
November 10, 2016
WEBD3201
The list preview page that will show single houses.
*/
$title = "***";
$date = "November 06, 2016";
$filename = "listing-matches.php";
$description = "The listing display page for individual house listing ";
include("header.php");
?>
<?php
$list_id = 3728;
$dirname = "listing/$list_id/";
$images = glob($dirname."*");

$sql = "SELECT * FROM listings WHERE listing_id = $list_id";
			$result = pg_query(db_connect(), $sql);
			$records = pg_num_rows($result);

//lists agents listings: SELECT * FROM listings WHERE user_id = 'aladila'

//Must have the user log in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']==false)
{
	header("Location: login.php");
}
else if ($_SESSION['username'] != pg_fetch_result($result, 0, "user_id") )
{
	echo $_SESSION['username']." is not owner. ".pg_fetch_result($result, 0, "user_id")." is the owner";
}
else if ($_SESSION['user_type'] != GET_AGENT)
{
	header("Location: index.php");
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	
	$target_dir = "./listing/$list_id/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) 
	{
        echo "<BR>File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "<BR>File is not an image.";
        $uploadOk = 0;
    }	
	
	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "<BR>Sorry, file already exists.";
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > IMAGE_SIZE_LIMIT) {
	    echo "<BR>Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" ) {
	    echo "<BR>Sorry, only JPG file are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} 
	else 
	{
		echo "<br>$target_dir".$_FILES["fileToUpload"]["name"];
		if (is_dir($target_dir))
		{
			echo "<BR>Folder exist";
			//mkdir("./".$list_id."/", 0777)
		}
		else
		{
			echo "<BR>Folder does not exist";
			mkdir("$target_dir", 0777);
		}
		
		
		
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
		{
			echo "<BR>Permissions: ".chmod("$target_dir".$_FILES["fileToUpload"]["name"], 0777)."";
			echo "<BR>code: chmod(\"$target_dir". $_FILES["fileToUpload"]["name"].", 0777).";
			
			//Changes permission
			chmod("$target_dir".$_FILES["fileToUpload"]["name"], 0777);
			
			$filecount = 0;
			if ($images){
				$filecount = count($images);
				echo $filecount;
			}
			$trust = true;
			
			$newName = $target_dir ."".$list_id."_". $filecount.".jpg";
			echo $newName;
			$i = 0;
			do {
				echo "<BR>Loop $i";
				$newName = $target_dir ."".$list_id."_". $i.".jpg";
				if (file_exists($newName) )
				{
					
					$i +=1;
				}
				else
				{
					rename("$target_dir".$_FILES["fileToUpload"]["name"], $newName);
					
						$trust = false;
				}
			} while ($trust);
			
			
			//rename("$target_dir".$_FILES["fileToUpload"]["name"], $newName);
			
	        echo "<BR>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			//header("Location: test3.php");
	    } else {
	        echo "<BR>Sorry, there was an error uploading your file.";
	    }
	}
}
if (isset($_POST["save"]))
{
	echo "SAVED";
}

?>


<form action="test3.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<form action="test3.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="submit" value="Save Image" name="save">
	<input type="submit" value="Delete Chosen Images" name="delete">


<?php


echo "<table border=\"1\">";
	echo "<tr>";
		echo "<th>Image</th><th>Checkbox</th>";
	echo "</tr>";
	//Loops any images that has been found
	foreach($images as $image) {
	echo "\n";
	echo "<tr>";
	echo "\n\t<td>";
    echo '<a href="test3.php?submit=Search+source+code&remove='.$image.'"><img src="'.$image.'" width=\"100\"/></a><br />';
	echo "\n\t\t</td>";
	echo "\n\t\t<td><input name=\"formDoor[]\" type=\"checkbox\" class=\"select\"  value=\"$image\"/></td>";
	echo "\n\t</tr>";
	}
	
echo "</table>";
echo "</form>";

if (isset($_GET['remove']))
{
	$dumValid = $_GET['remove'];
	if (file_exists($dumValid) )
	{
		if (!unlink($dumValid))
		  {
		  echo ("Error deleting $dumValid");
		  }
			else
		  {
		  echo ("Deleted $dumValid");
		  }
		  
		$filecount = 0;
		if ($images){
			$filecount = count($images);
			$filecount -= 1;
			echo $filecount;
		}
		//Removes the file if there is no more files in the folder
		if ($filecount == 0)
		{
			rmdir($dirname);
			echo "<br>Remove Folder";
		}
		header("Location: test3.php");
	}
	else
	{
		echo "Invalid file name";
	}
}	

if (isset($_POST["delete"]))
{
	echo "Delete Clicked";
	if (isset($_POST['formDoor']) )
	{
		echo "test";
		$test23 = $_POST['formDoor'];
		print_r($test23);
		foreach ($test23 as $file) 
		{
			echo "<br>File selected: ".$file;
			if(file_exists($file)) 
			{
				unlink($file); 
				echo "<br>Delete file";
			}
			$filecount = 0;
			if ($images){
				$filecount = count($images);
				$filecount -= count($test23);
				echo "<br>file count: ".$filecount;
			}
			//Removes the file if there is no more files in the folder
			
		}
		if ($filecount <= 0)
		{
			rmdir($dirname);
			echo "<br>Remove Folder";
		}
		echo "Files deleted successfully.";
	}
}



?>
<?php include 'footer.php'; ?>
