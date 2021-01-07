<?php
/*
Group 13
November 10, 2016
WEBD3201
The list preview page that will show single houses.
*/
$title = "Display Preview";
$date = "November 06, 2016";
$filename = "listing-matches.php";
$description = "The listing display page for individual house listing ";
include("header.php");
?>
<?php
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	$favouriteFound = 0;
	$reportFound = 0;
	
	$_SESSION['listing_id'] =  (isset($_GET['listing_id']))? $_GET['listing_id']: 0;
	if (isset($_GET['listing_id']))
	{
		//$_SESSION['listing_id'] = $_GET['listing_id'];
	}
	else
	{
		//$_SESSION['listing_id'] = 0;
		echo "ERROR: listing information was not find but please look at our first ever house on our website for 30 seconds";
		header("refresh:30;url=listing-cities.php");
		ob_flush();
	}
		
	$sql = 'SELECT * FROM listings WHERE listing_id = ' . $_SESSION['listing_id'];
	//echo "<BR>".$sql;
	$result = pg_query(db_connect(), $sql);
	$records = pg_num_rows($result);
	
	//Admin can check all pages
	if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == GET_ADMIN)
	{
	}
	//Checks if the creator tries to enter a disabled webpage
	else if (pg_fetch_result($result, 0, "status") == DISABLED)
	{
		header("Location: listing-cities.php");
	}
	//Checks if the creator tries to enter a disabled webpage
	else if (pg_fetch_result($result, 0, "status") == CLOSED)
	{
		header("Location: listing-cities.php");
	}
	
	if (isset($_POST['submit']))
	{
		header("location: ".$_SESSION['previousPage']);
	}
	if (isset($_POST['disable']))
	{
		echo "Disable";
		$disable = "UPDATE listings SET status='".DISABLED."' WHERE listing_id=". $_SESSION['listing_id'];
		pg_query(db_connect(), $disable);
		$disable_user = "UPDATE users SET user_type='".GET_DISABLED."' WHERE user_id='". pg_fetch_result($result, 0, "user_id")."';";
		pg_query(db_connect(), $disable_user);
		
		//Closes any existing reports related to the page
		$getReports = pg_query(db_connect(), "SELECT * FROM reports JOIN users ON reports.user_id = users.user_id JOIN people ON users.user_id = people.user_id WHERE listing_id=".$_SESSION['listing_id']);
		while($runrows = pg_fetch_assoc($getReports))
		{
			$user_id = $runrows['user_id'];
			$listing_id = $runrows['listing_id'];
			$date = $runrows['reported_on'];
			$firstNameReport = $runrows['first_name'];
			$lastNameReport = $runrows['last_name'];
			
			$close = "UPDATE reports SET status='".CLOSED."' WHERE listing_id=". $_SESSION['listing_id'];
			pg_query(db_connect(), $close);
			
		}
		header("Location: $actual_link");
	}
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] == GET_USER) 
	{
		//--------------------------------------------------------------------------------------------------------FAVOURITES
		if (isset($_POST['favourite']))
		{
			$insertSQL = "INSERT INTO favourites VALUES('".$_SESSION['username']."', '".$_SESSION['listing_id']."')";
			pg_query(db_connect(), $insertSQL);
		}
		//------------------------------------------------Unfavourite
		if (isset($_POST['unfavourite']))
		{
			$insertSQL = "DELETE FROM favourites WHERE user_id ='".$_SESSION['username']."' AND listing_id ='".$_SESSION['listing_id']."';";
			pg_query(db_connect(), $insertSQL);
		}
		
		$favouriteSQL = "SELECT * FROM favourites WHERE user_id = '".$_SESSION['username']."' AND listing_id = '".$_SESSION['listing_id']."'";
		$fav = pg_query(db_connect(), $favouriteSQL);
		$favRow = pg_num_rows($fav);
		if ($favRow == 1)
		{
			$favouriteFound = 1;
		}
		else
		{
			$favouriteFound = 0;
		}
		//-------------------------------------------------------------------------------------------END FAVOURITES
		
		//______________________________________________REPORT
		if (isset($_POST['report']))
		{
			$insertSQL = "INSERT INTO reports VALUES('".$_SESSION['username']."', '".$_SESSION['listing_id']."', '".date("Y-m-d",time())."', '".OPEN."')";
			pg_query(db_connect(), $insertSQL);
			$reportFound = 1;
		}
		$reportSQL = "SELECT * FROM reports WHERE user_id = '".$_SESSION['username']."' AND listing_id = '".$_SESSION['listing_id']."'";
		$report = pg_query(db_connect(), $reportSQL);
		$reportRow = pg_num_rows($report);
		if ($reportRow == 1)
		{
			$reportFound = 1;
		}
		else
		{
			$reportFound = 0;
		}
	}

	//Folder location
	$dirname = "./listing/".pg_fetch_result($result, 0, "listing_id")."/";
	//Gets any images in folder
	$images = glob($dirname."*");
	
?>
<!-- about section start -->
<section class="content-body result" id='result'>
        <div class="max-width body-place">			
			<h2 class="title"><?php echo pg_fetch_result($result, 0, "headline") ?></h2>
			<div class="row-info">
				<div class="column left">
				<?php
				if (file_exists("./listing/".pg_fetch_result($result, 0, "listing_id")."/".pg_fetch_result($result, 0, "listing_id")."_".pg_fetch_result($result, 0, "images").".jpg")) 
				{
				    echo "<img src=\"./listing/".pg_fetch_result($result, 0, "listing_id")."/".pg_fetch_result($result, 0, "listing_id")."_".pg_fetch_result($result, 0, "images").".jpg\" alt=\"House Image\" width=\"300px\"/>";
				}
				else
				{
					echo "<img src=\"images/notFound.jpg\" alt=\"Image Not Found\" width=\"300px\" />";
				}
				
				$i = 1;
				echo "<br/>";
				foreach($images as $image) {
					
					//Searchs for the underscore
					$testeee = strrpos($image, '_', 0) +1;
					//Gets the number infront
					$rest = substr($image, $testeee, 1);
					
				    echo '<img src="'.$image.'" width="50px" /> ';
					if ($i == 3)
					{
						echo "<br/>";
					}
					$i +=1;
				}
				
			?>
				</div>
				<div class="column right">
					<ul>
						<li>Open house?: <?php echo get_property('open_house', pg_fetch_result($result, 0, "open_house"))?> </li>
						<li>Finished Basement?: <?php echo get_property('finished_basement', pg_fetch_result($result, 0, "finished_basement"))?></li>
						<li><?php echo get_property('purchase_type', pg_fetch_result($result, 0, "purchase_type"))?></li>
						<li>Garage Type: <?php echo get_property('garage_type', pg_fetch_result($result, 0, "garage"))?></li>
						<li>Near school?: <?php echo get_property('schools', pg_fetch_result($result, 0, "schools"))?></li>
						<li>Status: <?php echo get_property('listing_status', strtolower(pg_fetch_result($result, 0, "status"))) ?></li>
						<li>Washrooms: <?php echo get_property('washrooms',pg_fetch_result($result, 0, "bathrooms"))  ?></li>
						<li>Bedrooms: <?php echo get_property('bedrooms',pg_fetch_result($result, 0, "bedrooms"))  ?></li>
						<li>Description: <?php echo pg_fetch_result($result, 0, "description")  ?></li>
					</ul>
					<ul>
						<li>Location: <?php echo get_property('cities',pg_fetch_result($result, 0, "city"))  ?></li>
						<li>Postal Code: <?php echo pg_fetch_result($result, 0, "postal_code") ?></li>
						<li>Price: $<?php echo number_format(pg_fetch_result($result, 0, "price") , 2)?></li>
					</ul>
				</div>
			</div>
			<div class="row-info">
				<form action="<?php echo $actual_link; ?>" method="post">
				<?php 
					if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] == GET_ADMIN) 
					{
						//If list is already disabled, then no button
						if (pg_fetch_result($result, 0, "status") == DISABLED)
						{
							echo "<input style=\"align: center\" type=\"submit\" name=\"disable\" value=\"Disabled Already\" disabled/>";
						}
						else
						{
							echo "<input style=\"align: center\" type=\"submit\" name=\"disable\" value=\"Disable\" />";
						}
						
					}
					else if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] == GET_USER) 
					{
						//Checks if page has been favourited by user or not
						if ($favouriteFound == 1)
						{
							echo "<input style=\"align: center\" type=\"submit\" name=\"unfavourite\" value=\"Unfavourite\" />";
						}
						else
						{
							echo "<input style=\"align: center\" type=\"submit\" name=\"favourite\" value=\"Favourite\" />";
						}
						
						//Checks if page has been reported by user already
						if ($reportFound == 1)
						{
							echo "<input style=\"align: center\" type=\"submit\" name=\"REPORTED\" value=\"Reported Already\" disabled/>";
						}
						else
						{
							echo "<input style=\"align: center\" type=\"submit\" name=\"report\" value=\"Report\" />";
						}
						
					}
				
				
				?>
				
				</form> 
			</div>
			<div class="row-info btn-back">
				<form action="listing-view.php" method="post">
					<input style="align: center" type="submit" name="submit" value="Back" />
				</form>
			</div>
		</div>
</section>

<?php include 'footer.php'; ?>