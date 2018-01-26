<?php
/*
Group 13
September 29, 2016
WEBD3201
The listing display page
*/
$title = "Listing Display";
$date = "September 29, 2016";
$filename = "index.php";
$description = "The listing display page for individual houses ";
include("header.php");
?>
<?php
	if (isset($_GET['listing_id']))
	{
		$_SESSION['listing_id'] = $_GET['listing_id'];
	}
	else
	{
		$_SESSION['listing_id'] = 0;
		echo "ERROR: listing information was not find";
	}
	
	//$_SESSION['listing_id'] = 3800;
	
	$sql = 'SELECT * FROM listings WHERE listing_id = ' . $_SESSION['listing_id'];
	echo "<BR>".$sql;
	$result = pg_query(db_connect(), $sql);
	$records = pg_num_rows($result);
	
	
	/*
	echo "<BR>".pg_fetch_result($result, 0, "listing_id");
	echo "<BR>".pg_fetch_result($result, 0, "user_id");
	echo "<BR>".pg_fetch_result($result, 0, "status");
	echo "<BR>".pg_fetch_result($result, 0, "price");
	echo "<BR>".pg_fetch_result($result, 0, "headline");
	echo "<BR>".pg_fetch_result($result, 0, "description");
	echo "<BR>".pg_fetch_result($result, 0, "postal_code");
	echo "<BR>".pg_fetch_result($result, 0, "images");
	echo "<BR>".pg_fetch_result($result, 0, "city");
	echo "<BR>".pg_fetch_result($result, 0, "property_options");
	echo "<BR>".pg_fetch_result($result, 0, "bedrooms");
	echo "<BR>".pg_fetch_result($result, 0, "bathrooms");
	echo "<BR>".pg_fetch_result($result, 0, "garage");
	echo "<BR>".pg_fetch_result($result, 0, "purchase_type");
	echo "<BR>".pg_fetch_result($result, 0, "property_type");
	echo "<BR>".pg_fetch_result($result, 0, "finished_basement");
	echo "<BR>".pg_fetch_result($result, 0, "open_house");
	echo "<BR>".pg_fetch_result($result, 0, "schools");*/

?>
<h1> Listing Display </h1>
<hr/>
<table style="width:50%" border="1px solid black">
	<tr>
		<th>Listing Image</th>
		<th>Listing Description</th>
	</tr>
	<tr>
		<th rowspan="2">
			<img src="Houses/brampton_house.jpg" alt="Oshawa House" width="300px" height="200px"/>
		</th>

		<td align="left" valign="top">
		<h3><?php echo pg_fetch_result($result, 0, "headline")  ?></h3>
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
		</td>

	</tr>
	<tr>
		<td align="left" valign="top"><ul>
			<li>Location: <?php echo get_property('cities',pg_fetch_result($result, 0, "city"))  ?></li>
			<li>Postal Code: <?php echo pg_fetch_result($result, 0, "postal_code") ?></li>
			<li>Price: <?php echo pg_fetch_result($result, 0, "price") ?></li>
			</ul>
		</td>
	</tr>

</table>
<form action="listing-matches.php">
<p>
<input type="submit" name="submit" value="Back"/></p>
</form>
<?php include 'footer.php'; ?>