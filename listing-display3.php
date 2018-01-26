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
<h1> Listing Display</h1>
<hr/>
<table style="width:50%" border="1px solid black">
<tr>
<th>Listing Image</th>
<th>Listing Description</th>
</tr>


<tr>
<th rowspan="2"><img src="Houses/ajax.jpg" alt="Oshawa House" width="300px" height="200px"/>
</th>
<td align="left" valign="top">
<h3>Private Ajax home on quiet street</h3>
<ul>
<li>3 Garage Doors</li>
<li>Open House</li>
<li>For Sale</li>
<li>Near an Elementary and Highschool</li>
<li>Status: Open</li>
<li>4 Washrooms</li>
<li>6 Bedrooms</li>
<li>Description: Large driveway to accomodate for cars, and a third garage door to allow space for lawn mowers and extra outdoor machines to keep stored out of the way.</li>
</ul>

</td>
</tr>
<tr>
<td align="left" valign="top"><ul>
<li>Location: Ajax</li>
<li>Postal Code: B9K M8Y</li>
<li>Price: $1,700,000</li>
</ul></td>
</tr>

</table>
<form action="search-result.php">
<p>
<input type="submit" name="submit" value="Back to search results "/></p>
</form>

<?php include 'footer.php'; ?>