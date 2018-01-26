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
<h1> Listing Display </h1>
<hr/>
<table style="width:50%" border="1px solid black">
<tr>
<th>Listing Image</th>
<th>Listing Description</th>
</tr>


<tr>
<th rowspan="2"><img src="Houses/pickering.JPG" alt="Pickering House" width="300px" height="200px"/>
</th>
<td align="left" valign="top">
<h3>Pickering home perfect for two people</h3>
<ul>
<li>Duplex</li>
<li>For Rent or Sale</li>
<li>Open House</li>
<li>Corner Lot</li>
<li>Status: Open</li>
<li>2 Washrooms</li>
<li>2 Bedrooms</li>
<li>Description: Ideal home for someone not looking to climb flights of stairs everyday but still have the space for needs in a house. Open to buy or rent.</li>
</ul>

</td>
</tr>
<tr>
<td align="left" valign="top"><ul>
<li>Location: Pickering</li>
<li>Postal Code: C7C G8F</li>
<li>Price: $300,000</li>
</ul></td>
</tr>
</table>

<form action="search-result.php">
<p>
<input type="submit" name="submit" value="Back to search results "/></p>
</form>
<?php include 'footer.php'; ?>