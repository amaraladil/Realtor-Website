<?php
/*
Group 13
November 24, 2016
WEBD3201
The listing update page
*/
$title = "Listing Update";
$date = "November 24, 2016";
$filename = "listing-update.php";
$description = "The Listing update page which update the listings information ";
include("header.php");
?>


<?php 
$error = "";
$output = "";

//Gets the actual link
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//Gets all of the values where the listing id matches
$listing_id = (isset($_GET['listing_id']))? $_GET['listing_id']: 0;
$sql = "SELECT * FROM listings WHERE listing_id=$listing_id";
$query = pg_execute(db_connect(), "get_listing",array($listing_id));


if (!isset($_SESSION['loggedin'])) 
{
	header("Location: login.php");
	ob_flush();
}
if(isset($_SESSION['user_type']))
{
	if ($_SESSION['user_type'] == GET_USER)
	{
		header("Location: welcome.php");
		ob_flush();
	}
	
	//If logged in user is not the same as the listing creator
	else if ($_SESSION['username'] != pg_fetch_result($query, 0, "user_id"))
	{
		header("Location: dashboard.php");
	}
}

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	
	//default mode when the page loads the first time
	//can be used to make decisions and initialize variables
	//ROW 1
	$beds = pg_fetch_result($query, 0, "bedrooms");
	$wash = pg_fetch_result($query, 0, "bathrooms");
	$open = pg_fetch_result($query, 0, "open_house");
	$basement = pg_fetch_result($query, 0, "finished_basement");
	//ROW 2
	$purchase = pg_fetch_result($query, 0, "purchase_type");
	$extraoptions = pg_fetch_result($query, 0, "property_options");
	$garage = pg_fetch_result($query, 0, "garage");
	//ROW 3
	$schools = pg_fetch_result($query, 0, "schools");
	$status = strtolower(pg_fetch_result($query, 0, "status"));
	$cities = pg_fetch_result($query, 0, "city");
	$headline = pg_fetch_result($query, 0, "headline");
	//ROW 4
	$info = pg_fetch_result($query, 0, "description");
	$price = pg_fetch_result($query, 0, "price");
	$postal = pg_fetch_result($query, 0, "postal_code");
	$property = pg_fetch_result($query, 0, "property_type");
   
	
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	//When upload page is uploaded
	if (isset($_POST['upload']))
	{
		header("Location: listing-images.php?submit=Search+source+code&listing_id=$listing_id");
	}
	//the page got here from submitting the form, let's try to process
	//ROW 1
	$beds = trim($_POST["bedrooms"]); 
	$wash = trim($_POST["washrooms"]); 
	if (isset($_POST['open_house'])){ $open = ($_POST["open_house"]); }else{ $open = "";	}
	if (isset($_POST['finished_basement'])){ $basement = ($_POST["finished_basement"]); }else{$basement = "";}
	//ROW 2
	$purchase = ($_POST["purchase_type"]); 
	$extraoptions = ($_POST["property_options"]); 	
	$garage = ($_POST['garage_type']);
	if ( isset($_POST['schools'])){ $schools = ($_POST['schools']); }else{ $schools = ""; }
	if ( isset($_POST['listing_status'])){ $status = ($_POST['listing_status']); }else{$status = "";}
	$cities = ($_POST['cities']);
	$headline = trim($_POST['headline']);
	$info = trim($_POST['description']);
	$price = trim($_POST['price']);
	$postal = trim($_POST['postal']);
	$property = ($_POST["property_type"]);
	
	
	//If the submit button was clicked
	if (isset($_POST["submit"] ) )
	{
		//bedrooms validation 
		if(!isset($beds) || $beds  == "")
		{
			//means the user did not enter anything
			$error .= "Select how many bedrooms. <br/>";
		}
		
		//washrooms validation 
		if(!isset($wash) || $wash  == "")
		{
			//means the user did not enter anything
			$error .= "Select how many washrooms. <br/>";
		}
		
		//open house validation 
		if(!isset($open) || $open  == "")
		{
			//means the user did not enter anything
			$error .= "Select an open house option. <br/>";
		}
		
		//finished basement validation 
		if(!isset($basement) || $basement  == "")
		{
			//means the user did not enter anything
			$error .= "Select a basement option. <br/>";
		}
		
		//purchase type validation 
		if(!isset($purchase) || $purchase  == "")
		{
			//means the user did not enter anything
			$error .= "Select the type of purchase. <br/>";
		}
		
		//price validation
		if(!isset($price) || $price == "")
		{
			//means the user did not enter anything
			$error .= "Price cannot be empty. <br/>";
		}
		else if (!is_numeric($price))
		{
			$error .= "Price must be numeric. <br/>";
		}
		
		//house type validation 
		if(!isset($property) || $property  == "")
		{
			//means the user did not enter anything
			$error .= "Select the type of house. <br/>";
		}
		
			//garage validation 
		if(!isset($garage) || $garage  == "")
		{
			//means the user did not enter anything
			$error .= "Select the type of garage. <br/>";
		}
		
		//description validation 
		if(!isset($info) || $info  == "")
		{
			//means the user did not enter anything
			$error .= "Description cannot be empty. <br/>";
		}
		
		//headline validate
		if(!isset($headline) || $headline == "")
		{
			//means the user did not enter any dap
			$error .= "Headline cannot be empty. <br/>";
		}
		
		//Extra options validation 
		if(!isset($extraoptions) || $extraoptions  == "")
		{
			//means the user did not enter anything
			$error .= "Select a Property Option. <br/>";
		}
		
		//status validation 
		if(!isset($status) || $status  == "")
		{
			//means the user did not enter anything
			$error .= "Select a status of the listing. <br/>";
		}

		//school validation 
		if(!isset($schools) || $schools  == "")
		{
			//means the user did not enter anything
			$error .= "Select if the listing is near any schools. <br/>";
		}
		
		
		
		//postal code validation 
		if(!isset($postal) || $postal == "")
		{
			//means the user did not enter anything
			$error .= "Postal Code cannot be empty. <br/>";
		}
		else if (is_valid_postal_code($postal))
		{
			$error .= "Postal Code (".$postal.") is not a valid Postal Code<br/>";
			$postal = "";
		}
		
		//city validation 
		if(!isset($cities) || $cities  == "")
		{
			//means the user did not enter anything
			$error .= "Select a city. <br/>";
		}
		
		//if error is an empty string
		if($error == "")
		{  
/*		echo "<br/>User ID: ".$_SESSION['username'];
			echo "<br/>Status: ". strtoupper($status);
			echo "<br/>Price: " .$price;
			echo "<br/>Headline: ".$headline;
			echo "<br/>Description: ".$info;
			echo "<br/>Postal Code: ".strtoupper($postal);
			echo "<br/>Image: ". $image = 1;
			echo "<br/>City: ".$cities;
			echo "<br/>Property Option: ".$extraoptions;
			echo "<br/>Bathroom: ". $wash;
			echo "<br/>Garage: ". $garage;
			echo "<br/>Purchase Type: ". $purchase;
			echo "<br/>Property Type: ". $property;
			echo "<br/>Finished Basement: ". $basement;
			echo "<br/>Open House: ". $open;
			echo "<br/>Schools: ". $schools;*/
			$total_row = pg_num_rows( pg_query(db_connect(), 'select * from listings') );
			pg_execute(db_connect(),"update_listings",array(strtoupper($status), $price, $headline, $info, strtoupper($postal), $cities, $extraoptions, $beds, $wash, $garage, $purchase, $property, $basement, $open, $schools, $listing_id) );
			
			$output = "The Listing Has Been Updated";
		}
	}
	/*
	
	0
Notice: Undefined variable: image in C:\Users\Troll\Desktop\Durham College\Semester 3\WEBD\GROUP\listing-create.php on line 220

Warning: pg_execute() [function.pg-execute]: Query failed: ERROR: null value in column "images" violates not-null constraint DETAIL: Failing row contains (0, aladila, O, 223, COOL, aaaaw, L1T2N1, null, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1). in C:\Users\Troll\Desktop\Durham College\Semester 3\WEBD\GROUP\listing-create.php on line 220
	*/
	
}
	 	 	
?>
<section class="content-body" id='formSetup'>
        <div class="max-width body-place">			
			<h2 class="title">Listing Update</h2>
			<form action="<?php echo $actual_link;  ?>" method="post" >
				<h2 style="text-align: center;"><?php echo $output; ?></h2>
				<h3 style="text-align: center;"><?php echo $error; ?></h3>
				<h3 style="text-align: center;">[ Inputs must not be empty when editting. ]</h3>
				<br/>
				<div class="otherForm">
					<?php
					$table = 'bedrooms';
					echo build_simple_dropdown($table, $beds);
					?>
					<label>Number of bedrooms:</label>
				</div>
				<div class="otherForm">
					<?php 
					$table = 'washrooms';
					echo build_dropdown($table, $wash);
					?>
					<label>Number of Washrooms:</label>
				</div>
				<div class="radioForm">
					<div>
					Open House?:
					</div>
					<?php 
					$table = 'open_house';
					echo build_radio($table, $open);
					?>
				</div>
				<div class="radioForm">
					<div>
					Finished basement?:
					</div>
					<?php 
					$table = 'finished_basement';
					echo build_radio($table, $open);
					?>
				</div>
				<div class="otherForm">
					<?php 
					$table = 'purchase_type';
					echo build_dropdown($table, $purchase);
					?>
					<label>Type of Listing:</label>
				</div>
				<div class="input-field">
					<input type="text" name="price" value="<?php echo $price; ?>" size="30" />
					<label>Price:</label>
				</div>
				<div class="otherForm">
					<?php 
					$table = 'property_type';
					echo build_dropdown($table, $property); 
					?>
					<label>Type of House:</label>
				</div>
				<div class="otherForm">
					<?php
					$table = 'garage_type';
					echo build_dropdown($table, $garage); ?>
					<label>Garage Type:</label>
				</div>
				<div class="otherForm">
					<input type="submit" name="upload"  value="Upload Page" />
					<label> Current Image: <?php echo pg_fetch_result($query, 0, "images"); ?></label>
				</div>
				<div class="otherForm">
					<textarea name = "description" rows="4" cols="30"><?php echo htmlspecialchars($info);?></textarea>
					<label>Description:</label>
				</div>
				<div class="input-field">
					<input type="text" name="headline" value="<?php echo $headline; ?>" size="30" />
					<label>Headline:</label>
				</div>
				<div class="otherForm">
					<?php 
					$table = 'property_options';
					echo build_dropdown($table, $extraoptions);?>
					<label>Property Options:</label>
				</div>
				<div class="radioForm">
					<div>
					Status:
					</div>
					<?php 
					$table = 'listing_status';
					echo build_radio($table, $status);
					?>
				</div>
				<div class="radioForm">
					<div>
					Near a School:
					</div>
					<?php 
						$table = 'schools';
						echo build_radio($table, $schools);
					?>
				</div>
				<div class="input-field">
					<input type="text" name="postal" value="<?php echo $postal; ?>" size="30" />
					<label>Postal Code:</label>
				</div>
				<div class="otherForm">
					<?php 
					$table = 'cities';
					echo build_dropdown($table, $cities);
					?>
					<label>City:</label>
				</div>
				<input type="submit" name="submit" value="Update Listing"/>
			</form>
		</div>
</section>
<?php include 'footer.php'; ?>