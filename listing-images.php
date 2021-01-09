<?php
/*
Group 13
November 25, 2016
WEBD3201
The image upload page, so user can upload their own photos for the listing
*/
$title = "Image Upload Page";
$date = "November 25, 2016";
$filename = "listing-matches.php";
$description = "Image Upload page where they can upload JPG images to the server ";
include("header.php");
?>
<?php
$error = "";
$output = "";
	//Gets the actual link
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	//Gets the listing Id value
	$list_id =  (isset($_GET['listing_id']))? $_GET['listing_id']: 0;
	//Makes the sql query
	$sql = "SELECT * FROM listings WHERE listing_id=$list_id";
	$result = pg_execute(db_connect(), "get_listing",array($list_id));
	
	if (!isset($_GET['listing_id']) )
	{
		header("Location: index.php");
	}
	//If the user logged in does not match the user who created the listing
	if ($_SESSION['username'] != pg_fetch_result($result, 0, "user_id"))
	{
		header("Location: dashboard.php");
	}
	//Folder location
	$dirname = "./listing/$list_id/";
	//Gets any images in folder
	$images = glob($dirname."*");
	
	//If there are any message sessions created
	if (isset($_SESSION['imageMessage']))
	{
		$output .= $_SESSION['imageMessage'];
		unset($_SESSION['imageMessage']);
	}
	
	$filecount = 0;
	//Check the amount of images in listing
	if ($images)
	{
		$filecount = count($images);
	}
	
	//Checks listing image limit
	if ($filecount >= IMAGE_AMOUNT_LIMIT)
	{
		$error .= "<BR>Please delete image/images to be able to upload, be below ".IMAGE_AMOUNT_LIMIT." images.";
	}
	
	//When user enters the page
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		//echo UPLOAD_ERR_OK;
	}
	//When someone clicks to upload
	if(isset($_POST["submit"])) 
	{
		
		$target_dir = $dirname;
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		
		// Check if image file is a actual image or fake image
	    if($check !== false) 
		{
	        //echo "<BR>File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        $error .= "<BR>File is not an image.";
	        $uploadOk = 0;
	    }	
		
		//Checks listing image limit
		if ($filecount >= IMAGE_AMOUNT_LIMIT)
		{
			$uploadOk = 0;
		}
		
		if ($_FILES["fileToUpload"]["name"] == "")
		{
			$error .= "<BR>Cannot upload empty file.";
		}
		
		// Check if file already exists
		else if (file_exists($target_file)) {
		    $error .= "<BR>Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > IMAGE_SIZE_LIMIT) {
		    $error .= "<BR>Sorry, your file is too large, must be below ".IMAGE_SIZE_LIMIT ." bytes.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" ) {
		    $error .= "<BR>Sorry, only JPG file are allowed.";
		    $uploadOk = 0;
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0 || $_FILES['file']['error'] != UPLOAD_ERR_OK) {
		    $error .= "<br/>Please choose an image that matches our requirement.";
		// if everything is ok, try to upload file
		} 
		else 
		{
			//If folder does not exist, then it will make it for the user
			if (!is_dir($target_dir))
			{
				mkdir("$target_dir", 0777);
			}
			
			//If the website allows the file to be moved, then it will be true
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
			{
				echo "<BR>Permissions: ".chmod("$target_dir".$_FILES["fileToUpload"]["name"], 0777)."";
				echo "<BR>code: chmod(\"$target_dir". $_FILES["fileToUpload"]["name"].", 0777).";
				
				//Changes permission
				chmod("$target_dir".$_FILES["fileToUpload"]["name"], 0777);
				
				$filecount = 0;
				if ($images){
					$filecount = count($images) +1;
					echo $filecount;
				}
				$trust = true;
				
				$newName = $target_dir ."".$list_id."_". $filecount.".jpg";
				echo $newName;
				$i = 1;
				//Loops until it finds the right name to rename file as
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
				
								
		        $_SESSION['imageMessage'] = "<BR>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				header("Location: $actual_link");
		    } else {
				//If file was not able to be moved
		        $error .= "<BR>Sorry, there was an error uploading your file.";
		    }
		}
	}
	if (isset($_POST['rdoMain']) )
	{
		$mainValue = $_POST['rdoMain'];
	}
	else
	{
		$mainValue = (pg_fetch_result($result, 0, "images") != 0)  ? pg_fetch_result($result, 0, "images"): 0;
	}
	
	if (isset($_POST["save"]))
	{
		//UPDATE listings SET images=0 WHERE listing_id=1484
		pg_execute(db_connect(),"update_image",array($mainValue, $list_id));
		$output = "Main Image Saved";
	}
	
	//____________________________________________Delete Functionality
	if (isset($_POST["delete"]))
	{
		$output .= "Delete Clicked";
		if (isset($_POST['imageSet']) )
		{
			$filesDeleted = $_POST['imageSet'];
			foreach ($filesDeleted as $file) 
			{
				echo "<br>File selected: ".$file;
				if(file_exists($file)) 
				{
					unlink($file); 
					echo "<br>Delete file";
				}
				$filecount = 0;
				if ($images)
				{
					$filecount = count($images);
					$filecount -= count($filesDeleted);
				}
			}
			//Removes the file if there is no more files in the folder
			if ($filecount <= 0)
			{
				rmdir($dirname);
			}
			$_SESSION['imageMessage'] = "Files deleted successfully.";
			header("Location: $actual_link");
		}
	}
	
	if (isset($_POST["goBack"]))
	{
		header("Location: listing-update.php?submit=Search+source+code&listing_id=$list_id");
	}
	
	
?>
<section class="content-body" id='formSetup'>
        <div class="max-width body-place">			
			<h2 class="title">Image Upload</h2>
			<h2 style="text-align: center;"><?php echo $output; ?></h2>
			<h3 style="text-align: center;"><?php echo $error; ?></h3>
			<form id="uploadform" enctype="multipart/form-data" method="post" action="<?php echo $actual_link; ?>">
				<strong>Select image for upload: </strong>
				<input type="file" name="fileToUpload" id="fileToUpload" required/>
				<input type="submit" value="Upload Image" name="submit"/>
			</form>
	<br/><br/>
	<form action="<?php echo $actual_link; ?>" method="post" enctype="multipart/form-data">
		    <input type="submit" value="Set Main Image" name="save">
			<input type="submit" value="Delete Chosen Images" name="delete">
			<input type="submit" value="Go Back to Update Page" name="goBack">

<?php


echo "<table border=\"1\">";
	
	$i=1;
	//Loops any images that has been found
	foreach($images as $image) {
		if ($i == 1)
		{	
			echo "<tr>";
				echo "<th>Image</th><th>Click to delete</th><th>Choose Main Image</th>";
			echo "</tr>";
		}
		//Searchs for the underscore
		$testeee = strrpos($image, '_', 0) +1;
		//Gets the number infront
		$rest = substr($image, $testeee, 1);
		echo "\n";
		echo "<tr>";
		echo "\n\t<td>";
	    echo '<img src="'.$image.'" width="300px" /><br /> ';
		echo "\n\t\t</td>";
		echo "\n\t\t<td><input name=\"imageSet[]\" type=\"checkbox\" class=\"select\"  value=\"$image\"/></td>";
		$check = ($image == "./listing/".$list_id."/".$list_id."_$mainValue.jpg")? "checked": "";
		echo "\n\t\t<td><input name=\"rdoMain\" type=\"radio\" class=\"select\" $check value=\"$rest\"/></td>";
		echo "\n\t</tr>";
		$i +=1;
	}
	
echo "</table>";
echo "</form>
</div>
</section>"

?>
<br>
<?php include 'footer.php'; ?>