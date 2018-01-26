<?php
/*
Group 13
September 29, 2016
WEBD3201
The search result page
*/
$title = "Search Result";
$date = "September 29, 2016";
$filename = "index.php";
$description = "The search result page ";
include("header.php");
?>
<h1> Listing Gallery </h1>
<hr/>
<table style="width:50%" border="1px solid black">
<tr>
<th>Listing Image</th>
<th>Listing Description</th>
</tr>

<tr>
<th rowspan="2"><img src="Houses/brampton_house.jpg" alt="Oshawa House" width="300px" height="200px"/>
</th>
<td align="left" valign="top"><ul>
<li>4 Washrooms</li>
<li>5 Bedrooms</li>
<li>Near a school</li>
</ul>
<form action="listing-display1.php">
<p>
<input type="submit" name="submit" value="Full listing description"/></p>
</form>
</td>
</tr>
<tr>
<td align="left" valign="top"><ul>
<li>Location: Oshawa</li>
<li>Price: $1,000,000</li>
</ul></td>
</tr>

<tr>
<th rowspan="2"><img src="Houses/bolmanville.jpg" alt="Oshawa House" width="300px" height="200px"/>
</th>
<td align="left" valign="top"><ul>
<li>Finished Basement</li>
<li>3 Bedrooms</li>
<li>Status: Open</li>
</ul>
<form action="listing-display2.php">
<p>
<input type="submit" name="submit" value="Full listing description"/></p>
</form>
</td>
</tr>
<tr>
<td align="left" valign="top"><ul>
<li>Location: Bowmanville</li>
<li>Price: $600,000</li>
</ul></td>
</tr>

<tr>
<th rowspan="2"><img src="Houses/ajax.jpg" alt="Oshawa House" width="300px" height="200px"/>
</th>
<td align="left" valign="top"><ul>
<li>3 Garage Doors</li>
<li>Open House</li>
<li>Near two schools</li>
</ul>
<form action="listing-display3.php">
<p>
<input type="submit" name="submit" value="Full listing description"/></p>
</form>
</td>
</tr>
<tr>
<td align="left" valign="top"><ul>
<li>Location: Ajax</li>
<li>Price: $1,700,000</li>
</ul></td>
</tr>

<tr>
<th rowspan="2"><img src="Houses/pickering.JPG" alt="Pickering House" width="300px" height="200px"/>
</th>
<td align="left" valign="top"><ul>
<li>Duplex</li>
<li>For Rent or Sale</li>
<li>2 washrooms</li>
</ul>
<form action="listing-display4.php">
<p>
<input type="submit" name="submit" value="Full listing description"/></p>
</form>
</td>
</tr>
<tr>
<td align="left" valign="top"><ul>
<li>Location: Pickering</li>
<li>Price: $300,000</li>
</ul></td>
</tr>
</table>

<?php include 'footer.php'; ?>