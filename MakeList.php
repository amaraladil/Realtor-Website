<?php
/*
Group 13
September 29, 2016
WEBD3201
The Welcome Page
*/
$title = "Welcome";
$date = "September 29, 2016";
$filename = "index.php";
$description = " A page that welcomes the agent";
include("header.php");
?>
<?php
//Current Max Listings
$CurrentListNumber = pg_num_rows(pg_query("Select * from listings"));

echo "<br>Current rows in listings: ".$CurrentListNumber."<br><br>";

//Current Agents availiable 
$AgentList = array();
//---------------------------------------------------------------------------------USER ID
$result = pg_query("SELECT user_id FROM users WHERE user_type = 'R';");
while ($row = pg_fetch_assoc($result)) {
   $AgentList = array_merge($AgentList, array_map('trim', explode(",", $row['user_id'])));
}
print_r(array_values($AgentList));
echo "<br/><br/>Number of Agents: ".count($AgentList);

//----------------------------------------------------------------------------------------STATUS
$status = array();
$result = pg_query("SELECT value FROM listing_status");
while ($row = pg_fetch_assoc($result)) {
   $status = array_merge($status, array_map('trim', explode(",", $row['value'])));
} 
echo "<br><br>Listing Status: ";
print_r(array_values($status));

//----------------------------------------------------------------------------------------------POSTAL CODE
$postalLetters = Array("A","B","C","E","G","H","J","K","L","M","N","P","R","S","T","V","X","Y");
$postal_prefix = Array(
				"Ajax" => Array("L1S", "L1T", "L1Z"),
				"Bowmanville" => Array("L1B", "L1C", "L1E"),
				"Brooklin" => "L1M",
				"Oshawa" => Array("L1G", "L1H", "L1J", "L1K", "L1L"),
				"Pickering" => Array("L1V", "L1W", "L1X", "L1Y"),
				"Port Perry" => "L9L",
				"Whitby" => Array("L1V", "L1W", "L1X", "L1Y")
				);
				
echo "<br><br>Postal Prefix: ";
print_r($postal_prefix);

//-------------------------------------------------------------------------------------CITY		
$city = array();
$result = pg_query("SELECT * FROM cities");
while ($row = pg_fetch_assoc($result)) {
   $city = array_merge($city, array_map('trim', explode(",", $row['value'])));
} 
echo "<br><br>City: ";
print_r(array_values($city));

//-----------------------------------------------------------------------------------OPTIONS
$options = array();
$result = pg_query("SELECT * FROM property_options");
while ($row = pg_fetch_assoc($result)) {
   $options = array_merge($options, array_map('trim', explode(",", $row['value'])));
} 
echo "<br><br>Options: ";
print_r(array_values($options));

//-----------------------------------------------------------------------------------BEDS
$bedrooms = array();
$result = pg_query("SELECT * FROM bedrooms");
while ($row = pg_fetch_assoc($result)) {
   $bedrooms = array_merge($bedrooms, array_map('trim', explode(",", $row['value'])));
} 
echo "<br><br>Bedroom: ";
print_r(array_values($bedrooms));

//echo "<br>" . $bedrooms[rand(0,count($bedrooms)-1)];
//-----------------------------------------------------------------------------------BATHS
$washrooms = array();
$result = pg_query("SELECT * FROM washrooms");
while ($row = pg_fetch_assoc($result)) {
   $washrooms = array_merge($washrooms, array_map('trim', explode(",", $row['value'])));
} 
echo "<br><br>Washroom: ";
print_r(array_values($washrooms));

//-----------------------------------------------------------------------------------GARAGE
$garage = array();
$result = pg_query("SELECT * FROM garage_type");
while ($row = pg_fetch_assoc($result)) {
   $garage = array_merge($garage, array_map('trim', explode(",", $row['value'])));
} 
echo "<br><br>Garage: ";
print_r(array_values($garage));

//-----------------------------------------------------------------------------------PURCHASE TYPE
$purchase_type = array();
$result = pg_query("SELECT * FROM purchase_type");
while ($row = pg_fetch_assoc($result)) {
   $purchase_type = array_merge($purchase_type, array_map('trim', explode(",", $row['value'])));
} 
echo "<br><br>purchase_type: ";
print_r(array_values($purchase_type));

//-----------------------------------------------------------------------------------PURCHASE TYPE
$property_type = array();
$result = pg_query("SELECT * FROM property_type");
while ($row = pg_fetch_assoc($result)) {
   $property_type = array_merge($property_type, array_map('trim', explode(",", $row['value'])));
} 
echo "<br><br>property_type: ";
print_r(array_values($property_type));

//-----------------------------------------------------------------------------------BASEMENT
$finished_basement = array();
$result = pg_query("SELECT * FROM finished_basement");
while ($row = pg_fetch_assoc($result)) {
   $finished_basement = array_merge($finished_basement, array_map('trim', explode(",", $row['value'])));
} 
echo "<br><br>finished_basement: ";
print_r(array_values($finished_basement));

//-----------------------------------------------------------------------------------OPEN HOUSE?
$open_house = array();
$result = pg_query("SELECT * FROM open_house");
while ($row = pg_fetch_assoc($result)) {
   $open_house = array_merge($open_house, array_map('trim', explode(",", $row['value'])));
} 
echo "<br><br>open_house: ";
print_r(array_values($open_house));

//-----------------------------------------------------------------------------------SCHOOLS
$schools = array();
$result = pg_query("SELECT * FROM schools");
while ($row = pg_fetch_assoc($result)) {
   $schools = array_merge($schools, array_map('trim', explode(",", $row['value'])));
} 
echo "<br><br>schools: ";
print_r(array_values($schools));

/*
open_house INTEGER DEFAULT(0) NOT NULL,
schools INTEGER DEFAULT(0) NOT NULL
*/

echo "<br>";
//------------------------------------------------------------------------------------START LOOP
$getID = $CurrentListNumber;
for ($x = 0; $x <= 1500; $x++)
{
	
	$getAgent = $AgentList[rand(0,count($AgentList)-1)];
	$getStatus = $status[rand(0,count($status)-1)];
	$getHeadline = "";
	$getDescripion = "";
	$getPostal = "";
	$getImage = rand(1,10000);
	$getCity = "";
	$getOptions = "";
	$getBed = "";
	$getBath = "";
	$getGarage = "";	
	$getPurchase = "";	
	$getProperty = "";	
	$getBasement = "";	
	$getHouse = "";	
	$getSchools = "";	
	
	$getCity = $city[rand(0,count($city)-1)];
	//To get the area code of the Postal CODE
	if ($getCity == 1)//AJAX
	{
		$getPostal = $postal_prefix['Ajax'][rand(0,2)];
	}
	elseif ($getCity == 2)//Bowmanville
	{
		$getPostal = $postal_prefix['Bowmanville'][rand(0,2)];
	}
	elseif ($getCity == 4)//Brooklin
	{
		$getPostal = $postal_prefix['Brooklin'];
	}
	elseif ($getCity == 8)//Oshawa
	{
		$getPostal = $postal_prefix['Oshawa'][rand(0,4)];
	}
	elseif ($getCity == 16)//Pickering
	{
		$getPostal = $postal_prefix['Pickering'][rand(0,3)];
	}
	elseif ($getCity == 32)//Port Perry
	{
		$getPostal = $postal_prefix['Port Perry'];
	}
	elseif ($getCity == 64)//Whitby
	{
		$getPostal = $postal_prefix['Whitby'][rand(0,3)];
	}	
	
	//----------------------------------------------------------------------------Postal Code Last three code
	for ($code = 1; $code <= 3; $code++)
	{
		if ($code % 2 == 0)
		{
			
			$getPostal .= $postalLetters[rand(0,(count($postalLetters)-1))];
		}
		else
		{
			$getPostal .= rand(0,9);
		}
	}	
	$getPrice = rand(100000,1000000);
	$getOptions = $options[rand(0,count($options)-1)];
	$getBed = $bedrooms[rand(0,count($bedrooms)-1)];
	$getBath = $washrooms[rand(0,count($washrooms)-1)];
	$getGarage = $garage[rand(0,count($garage)-1)];
	$getPurchase = $purchase_type[rand(0,count($purchase_type)-1)];
	$getProperty = $property_type[rand(0,count($property_type)-1)];
	$getBasement = $finished_basement[rand(0,count($finished_basement)-1)];
	$getHouse = $open_house[rand(0,count($open_house)-1)];
	$getSchools = $schools[rand(0,count($schools)-1)];
	
	
	$rand = rand(0,3);
	if ($rand == 0)
	{
		$getHeadline = "".get_property('property_type',$getProperty). " in " . get_property('cities',$getCity). " is ". get_property('purchase_type',$getPurchase); 
	}
	else if($rand == 1)
	{
		$getHeadline = "A ".get_property('property_type',$getProperty)." in ".get_property('cities',$getCity).", Ontario  ". $getPostal; 
	}
	else if($rand == 2)
	{
		$getHeadline = "". get_property('purchase_type',$getPurchase)." ".get_property('property_type',$getProperty)." in ".get_property('cities',$getCity)." ".$getPostal;
	}
	else
	{
		$getHeadline = "".get_property('purchase_type',$getPurchase).": a ".get_property('property_type',$getProperty). " in " . get_property('cities',$getCity); 
	}
	$result = pg_query("SELECT * FROM people where user_id = '". $getAgent ."';");
	$getContact = pg_query("SELECT * FROM people where user_id = '". $getAgent ."';");
	$getDescripion = "Agent: ". pg_fetch_result($result, 0, "first_name")." ".pg_fetch_result($result, 0, "last_name") ." Bedroom: ".get_property('bedrooms',$getBed). "\t\t Bathroom: ".get_property('washrooms',$getBath)." Building type: ".get_property('property_type',$getProperty)."\n Please contact by: ". get_property('contact_method',pg_fetch_result($result, 0, "preferred_contact_method"));
	
	echo "<br>";
	echo "<br>List ID: ". $getID;
	echo "<br>Agent's name: ". $getAgent;
	echo "<br>Listing Status: ". get_property('listing_status',$getStatus);
	echo "<br>Price: " . number_format($getPrice,2);
	echo "<br/>Headline: ". $getHeadline;
	echo "<br/>Description: ". $getDescripion;
	echo "<br/>Postal: ". $getPostal;
	echo "<br/>Image: ". $getImage;
	echo "<br/>City: ".get_property('cities',$getCity);
	echo "<br/>Property Options: ".	get_property('property_options',$getOptions);
	echo "<br/>Bedroom: ".	get_property('bedrooms',$getBed);
	echo "<br/>Bathroom: ".	get_property('washrooms',$getBath);
	echo "<br/>Garage: ".	get_property('garage_type',$getGarage);	
	echo "<br/>Purchase Type: ".	get_property('purchase_type',$getPurchase);	
	echo "<br/>Property Type: ".	get_property('property_type',$getProperty);	
	echo "<br/>Basement?: ".	get_property('finished_basement',$getBasement);	
	echo "<br/>Open House?: ".	get_property('open_house',$getHouse);	
	echo "<br/>Schools nearby: ". get_property('schools',$getSchools);	
	echo "<hr>";
	
	pg_execute(db_connect(),"insert_listings",array($getID, $getAgent, strtoupper($getStatus), $getPrice, $getHeadline, $getDescripion, strtoupper($getPostal), $getImage, $getCity, $getOptions, $getBed, $getBath, $getGarage, $getPurchase, $getProperty, $getBasement, $getHouse, $getSchools) );
	//echo "<br>".$sql;
	//pg_query(db_connect(), $sql);
	
	//Increments for the listings table as they need to be unique
	$getID = $getID + 1;
}

?>


		
<?php include 'footer.php'; ?>