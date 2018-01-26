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
<th rowspan="2"><img src="Houses/bolmanville.jpg" alt="Oshawa House" width="300px" height="200px"/>
</th>
<td align="left" valign="top">
<h3>Bowmanville home completely finished</h3>
<ul>
<li>Finished Basement</li>
<li>3 Bedrooms</li>
<li>For Sale</li>
<li>Double garage</li>
<li>Main room and basement fireplace</li>
<li>Status: Open</li>
<li>3 Washrooms</li>
<li>Description: Great home if you are interested in moving in without having to spend time and money as it has a finished basement including a washroom down there. </li>
</ul>
</td>
</tr>
<tr>
<td align="left" valign="top"><ul>
<li>Location: Bolmanville</li>
<li>Postal Code: P1W ME4</li>
<li>Price: $600,000</li>
</ul></td>
</tr>

</table>
<form action="search-result.php">
<p>
<input type="submit" name="submit" value="Back to search results "/></p>
</form>

<?php include 'footer.php'; ?>