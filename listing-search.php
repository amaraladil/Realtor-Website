<?php
/*
Group 13
November 10, 2016
WEBD3201
The Listing search page
*/
$title = "Listing Search";
$date = "November 10, 2016";
$filename = "index.php";
$description = "The Listing search page";
include("header-2.php");
?>
<?php 
$error = "";
$output = "";

$bed_table = 'bedrooms';
$wash_table = 'washrooms';
$open_table = 'open_house';
$base_table = 'finished_basement';
$type_table = 'purchase_type';
$property_table = 'property_type';
$city_table = 'cities';
$garage_table = 'garage_type';
$options_table = 'property_options';
$schools_table = 'schools';

$beds = (isset($_COOKIE[$bed_table]))?$_COOKIE[$bed_table]:0;	
$wash = (isset($_COOKIE[$wash_table]))?$_COOKIE[$wash_table]:0;	
$open = (isset($_COOKIE[$open_table]))?$_COOKIE[$open_table]:0;	
$base = (isset($_COOKIE[$base_table]))?$_COOKIE[$base_table]:0;	
$purchase = (isset($_COOKIE[$type_table]))?$_COOKIE[$type_table]:0;	
$minimum = (isset($_COOKIE['min']))?$_COOKIE['min']:"";	;
$maximum = (isset($_COOKIE['max']))?$_COOKIE['max']:"";	;	
$property_type = (isset($_COOKIE[$property_table]))?$_COOKIE[$property_table]:0;
$garage = (isset($_COOKIE[$garage_table]))?$_COOKIE[$garage_table]:0;
$options = (isset($_COOKIE[$options_table]))?$_COOKIE[$options_table]:0;
$schools = (isset($_COOKIE[$schools_table]))?$_COOKIE[$schools_table]:0;


if(!isset($city))//___________________________________________CITY
{
	$city=0; 
}
if (isset($_SESSION['city']) )
{
	$city = $_SESSION['city'];
} 

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	
	//default mode when the page loads the first time
	//can be used to make decisions and initialize variables
	//ROW 2
	if (isset($_GET['city']))
	{
		$_SESSION['city'] = $_GET['city'];
	}
	

}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$minimum = trim($_POST['minimum']);
	$maximum = trim($_POST['maximum']);
	
	
	
	if (isset($_POST[$bed_table])) //___________________________BEDS
	{
		$beds = sumCheckBox($_POST[$bed_table]);
		setcookie($bed_table, $beds, time()+ COOKIE_LENGTH, "/");
	}
	else
	{
		$beds = 0;
		setcookie($bed_table, $beds, time()+ COOKIE_LENGTH, "/");
	}
	
	if (isset($_POST[$wash_table])) //___________________________WASHROOM
	{
		$wash = sumCheckBox($_POST[$wash_table]);
		setcookie($wash_table, $wash, time()+ COOKIE_LENGTH, "/");
	}
	else
	{
		$wash = 0;
		setcookie($wash_table, $wash, time()+ COOKIE_LENGTH, "/");
	}
	
	if (isset($_POST[$open_table])) //___________________________OPEN HOUSE
	{
		$open = sumCheckBox($_POST[$open_table]);
		setcookie($open_table, $open, time()+ COOKIE_LENGTH, "/");
	}
	else
	{
		$open = 0;
		setcookie($open_table, $open, time()+ COOKIE_LENGTH, "/");
	}
	
	if (isset($_POST[$base_table])) //___________________________BASEMENT OR NOT
	{
		$base = sumCheckBox($_POST[$base_table]);
		setcookie($base_table, $base, time()+ COOKIE_LENGTH, "/");
	}
	else
	{
		$base = 0;
		setcookie($base_table, $base, time()+ COOKIE_LENGTH, "/");
	}
	
	if (isset($_POST[$type_table])) //___________________________TYPE OF PURCHASE, rent or sale
	{
		$purchase = sumCheckBox($_POST[$type_table]);
		setcookie($type_table, $purchase, time()+ COOKIE_LENGTH, "/");
	}
	else
	{
		$purchase = 0;
		setcookie($type_table, $purchase, time()+ COOKIE_LENGTH, "/");
	}
	
	//_________________________________________________________________________PRICE MINIMUM
		//minimum validate
	if(strlen($minimum) > 0 && !is_numeric($minimum))
	{
		//means the user did not enter any dap
		$error .= "Minimum price must be a number. <br/>";
	}
	//_________________________________________________________________________PRICE MAXIMUM
		//maximum validate
	if(strlen($maximum) > 0 && !is_numeric($maximum))
	{
		//means the user did not enter any dap
		$error .= "Maximum price must be a number. <br/>";
	}
	if ($error == "")
	{
		setcookie('min', $minimum, time()+ COOKIE_LENGTH, "/");
		setcookie('max', $maximum, time()+ COOKIE_LENGTH, "/");
	}
	
	if (isset($_POST[$property_table])) //___________________________PROPERTY TYPE
	{
		$property_type = sumCheckBox($_POST[$property_table]);
		setcookie($property_table, $property_type, time()+ COOKIE_LENGTH, "/");
	}
	else
	{
		$property_type = 0;
		setcookie($property_table, $property_type, time()+ COOKIE_LENGTH, "/");
	}
	
	if (isset($_POST[$garage_table])) //___________________________GARAGE TYPE FOR THE HOUSE
	{
		$garage = sumCheckBox($_POST[$garage_table]);
		setcookie($garage_table, $garage, time()+ COOKIE_LENGTH, "/");
	}
	else
	{
		$garage = 0;
		setcookie($garage_table, $garage, time()+ COOKIE_LENGTH, "/");
	}
	
	
	if (isset($_POST[$options_table])) //___________________________OPTION TYPE
	{
		$options = sumCheckBox($_POST[$options_table]);
		setcookie($options_table, $options, time()+ COOKIE_LENGTH, "/");
	}
	else
	{
		$options = 0;
		setcookie($options_table, $options, time()+ COOKIE_LENGTH, "/");
	}
	

	if (isset($_POST[$schools_table])) //___________________________SCHOOLS
	{
		$schools = sumCheckBox($_POST[$schools_table]);
		setcookie($schools_table, $schools, time()+ COOKIE_LENGTH, "/");
	}
	else
	{
		$schools = 0;
		setcookie($schools_table, $schools, time()+ COOKIE_LENGTH, "/");
	}
	
	echo $city;
	
	if ( ($city == 0))
	{
		$error .= "No city was chosen";
	}
	
	//_________________________________________________________________________________________________________AFTER EVERYTHING IS SET, IT WOULD TRANSFER ACROSS TO LISTING-MATCHES
	//___________________________________________________________________________________________CREATE WHERE STATEMENT
	if ($error == "")
	{
		$_SESSION['WhereStarted'] = true;
		$sqlPrepare = "";
		$sqlPrepare .= makeWhereStatement($bed_table, $beds, "bedrooms");
		$sqlPrepare .= makeWhereStatement($wash_table, $wash, "bathrooms");
		$sqlPrepare .= makeWhereStatement($open_table, $open, "open_house");
		$sqlPrepare .= makeWhereStatement($base_table, $base, "finished_basement");
		$sqlPrepare .= makeWhereStatement($type_table, $purchase, "purchase_type");
				if (strlen($minimum) > 0) //_________________________________________________MINIMUM
				{
					if ($_SESSION['WhereStarted'] == true)
					{
						$sqlPrepare .= " WHERE (price >= $minimum) ";
						//echo " WHERE (price >= $minimum) ";
					}
					else
					{
						$sqlPrepare .= " AND (price >= $minimum) ";
						//echo "AND (price >= $minimum) ";
					}
					$_SESSION['WhereStarted'] = false;
				}
				if (strlen($maximum) > 0) //____________________________________________________MAXIMUM
				{
					if ($_SESSION['WhereStarted'] == true)
					{
						$sqlPrepare .= "WHERE (price <= $maximum) ";
						//echo "WHERE (price <= $maximum)";
					}
					else
					{
						$sqlPrepare .= "AND (price <= $maximum) ";
						//echo " AND (price <= $maximum)";
					}
					$_SESSION['WhereStarted'] = false;
				}
		$sqlPrepare .= makeWhereStatement($property_table, $property_type, "property_type");
		$sqlPrepare .= makeWhereStatement($garage_table, $garage, "garage");
		$sqlPrepare .= makeWhereStatement($options_table, $options, "property_options");
		$sqlPrepare .= makeWhereStatement($schools_table, $schools, "schools");
		if (isset($_SESSION['city']) )
		{
			$sqlPrepare .= makeWhereStatement($city_table, $_SESSION['city'], "city");
		}
		if ($_SESSION['WhereStarted'] == true) //THIS WILL CAUSE THE SEARCH TO NOT SHOW ANY HOUSING THAT IS HIDDEN OR CLOSED
		{
			$sql_status = "WHERE status <> 'H' AND status <> 'C' AND status <> 'S' AND status <> 'D'";
		}
		else
		{
			$sql_status = "AND status <> 'H' AND status <> 'C' AND status <> 'S' AND status <> 'D'";
		}
		$_SESSION['Where'] = 'SELECT * FROM listings ' .$sqlPrepare ."".$sql_status;
		
		$constructs = $_SESSION['Where'] . " ORDER BY listings.listing_id LIMIT 200";
		$run = pg_query(db_connect(),$constructs);
	    
		$foundnum = pg_num_rows($run);	
			
		if ($foundnum >= 1)
		{
			header("Location: listing-matches.php");
			ob_flush(); 
		}
		else
		{
			$error .= "No listings match the critera";
		}
	}
}
?>

<!-- about section start -->
<section class="content-body" id='search'>
        <div class="max-width body-place  search">			
            <h2 class="title">Listing Search</h2>
			<form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post">
				<?php //___________________________USED TO DISPLAY THE CITIES
				
				$output = "";
				$sql = 'SELECT * FROM '.$city_table;
				$allOrNot = 0;
				$city_start = true;
				$result = pg_query(db_connect(), $sql);
				$records = pg_num_rows($result);
				for($i = 0; $i < $records; $i++)
				{
					if (isBitSet($i, $city))
					{
						if ($city_start == true)
						{
							$output = "Location: ". pg_fetch_result($result, $i, "property");
						}
						else
						{
							$output .= ", ".pg_fetch_result($result, $i, "property");
						}
						$allOrNot += 1;
						
						$city_start = false;
					}
					if ($allOrNot == $records || ($city == 0)) //IF ALL WERE PICKED OR NON WERE PICKED
					{
						$output = "Location: Durham Region";
					}
				}?>
				
				<h2 style="text-align: center;"><?php echo $output; ?></h2>
				<h3 style="text-align: center;"><?php echo $error; ?></h3>
				<div>
					# of bedrooms:<br/>
					<?php 
					echo build_checkbox($bed_table, $beds); 
					?>
				</div>
				<div>
					# of washrooms:<br/>
					<?php 
					echo build_checkbox($wash_table, $wash); 
					?>
				</div>
				<div>
					Open House?<br/>
					<?php 
					echo build_checkbox($open_table, $open); 
					?>
				</div>
				<div>
					House containing a finished basement?<br/>
					<?php 
					echo build_checkbox($base_table, $base); 
					?>
				</div>
				<div>
					Type of listing: 
					<br/>
					<?php 
					echo build_checkbox($type_table, $purchase); 
					?>
				</div>
				<div>
					Price for house: 
					<br/>
					Minimum price: <input type="text" name="minimum" value="<?php echo $minimum;?>" /><br/>
					Maximum Price: <input type="text" name="maximum" value="<?php echo $maximum;?>" />
				</div>
				<div>
					Type of house: 
					<br/>
					<?php 
					echo build_checkbox($property_table, $property_type); 
					?>
				</div>
				<div>
					Garage Type: 
					<br/>
					<?php 
					echo build_checkbox($garage_table, $garage); 
					?>
				</div>
				<div>
					Property Options:<br/>
					<?php 
					echo build_checkbox($options_table, $options); 
					?>
				</div>
				<div>
					Near schools?<br/>
					<?php 
					echo build_checkbox($schools_table, $schools); 
					?>
				</div>

				<input style="align: center" type="submit" name="submit" value="Submit" />
			</form>
        </div>
</section>


<?php include 'footer-2.php'; ?>