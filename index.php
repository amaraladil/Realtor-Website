<?php
/*
Group 13
September 29, 2016
WEBD3201
The main page 
*/
$title = "Home Page";
$date = "September 29, 2016";
$filename = "index.php";
$description = "Home Page for realtor";
include("header.php");
?>
		<div id="index">
		<!-- start of main page content. --> 
		<br/><br/>
		<h1>Welcome to Houses Connected&reg;</h1>
        <hr/>
		<h1>Your real estate needs ends here!</h1>
		<p>
			Tired of searching through the newspapers for real estate? Tried using other servies and had bad experiences?<br/>
			Houses Connected makes searching easier and faster.<br/> By having listers post their ad of their home, users can easily search
			through with many filters.
		</p>
		<br/>
		<table>
			<tr>
				<td><img src="./Houses/ajax.jpg" class="imagesize1" alt="Ajax House" /></td>
				<td><img src="./Houses/pickering.JPG" class="imagesize1" alt="Pickering House"/></td>
				<td><img src="./Houses/brampton_house.jpg" class="imagesize1" alt="Brampton House"/></td>
			</tr>
		</table>
		<br/>
		<h3>To start searching for your new home, click <a href="./listing-cities.php">HERE</a> or click "Search" on the top of the page.</h3>
		<h3>Returning user? Click <a href="./login.php">HERE</a> or click "Login" or "Register" if you're a new user.</h3>
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

		<!-- end of main page content -->
</div>		
		
<?php include 'footer.php'; ?>
