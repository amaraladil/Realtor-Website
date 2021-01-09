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
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$_SESSION['previousPage'] = $actual_link;
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] == GET_ADMIN) 
	{
		echo "<section class=\"content-body result\" id='result'>
			<div class=\"max-width body-place\">			
				<h2 class=\"title\">Welcome to the Admin's area, " . $_SESSION['username'] . "!</h2>
				<div class=\"row-info\">";

		echo "\n<br/>Password: ".$_SESSION['password']."  User Type: ".$_SESSION['user_type']."";
		echo "\n<br/>Email: " .$_SESSION['email']. "   Enrolled Date: ". $_SESSION['enrol']."";
		echo "\n<br/> Last Access: ".$_SESSION['last_access']."";
		echo "\n<br/> Personal Information";
		echo "\n<br/> Salutation: ".$_SESSION['salutation']."";
		echo "\n<br/> First Name: ".$_SESSION['first_name']."";
		echo "\n<br/> Last Name: ".$_SESSION['last_name']."";
		echo "\n<br/> 1st Street: ".$_SESSION['street_address_1']."";
		echo "\n<br/> 2nd Street: ".$_SESSION['street_address_2']."";
		echo "\n<br/> City: ".$_SESSION['city']."";
		echo "\n<br/> Provinces: ".$_SESSION['province']."";
		echo "\n<br/> Primary Phone: ". $_SESSION['primary_phone']."";
		echo "\n<br/> Secondary Phone: ". $_SESSION['secondary_phone']."";
		echo "\n<br/> Fax Number: ". $_SESSION['fax']."";
		echo "\n<br/> Preferred Contact Method: ".$_SESSION['contact_method']."";

		
		//When admin accepts agent is clicked
		if (isset($_GET['Accept_user']))
		{
			$findUser = "SELECT * FROM users WHERE user_id='".$_GET['Accept_user']."' ";
			$userFound = pg_query(db_connect(), $findUser);
			//Checks if user is stil pending, no backdoor system to update any user to change a user
			if (pg_fetch_result($userFound, 0, "user_type") == GET_PENDING)
			{
				$updateAgent = "UPDATE users SET user_type='".GET_AGENT."' WHERE user_id = '".$_GET['Accept_user']."'";
				pg_query(db_connect(), $updateAgent);
			}
			header("Location: admin.php");
		}
		//When admin disables pending agent
		if (isset($_GET['Disable_user']))
		{
			$findUser = "SELECT * FROM users WHERE user_id='".$_GET['Disable_user']."' ";
			$userFound = pg_query(db_connect(), $findUser);
			//Checks if user is stil pending, no backdoor system to update any user to change a user
			if (pg_fetch_result($userFound, 0, "user_type") == GET_PENDING)
			{
				$updateAgent = "UPDATE users SET user_type='".GET_DISABLED."' WHERE user_id = '".$_GET['Disable_user']."'";
				pg_query(db_connect(), $updateAgent);
			}
			header("Location: admin.php");
		}
		//When admin disables a spammy reporter
		if (isset($_GET['Disable_reporter']))
		{
			$findUser = "SELECT * FROM users WHERE user_id='".$_GET['Disable_reporter']."' ";
			$userFound = pg_query(db_connect(), $findUser);
			//Checks if user is stil pending, no backdoor system to update any user to change a user
			if (pg_fetch_result($userFound, 0, "user_type") != GET_DISABLED)
			{
				$updateAgent = "UPDATE users SET user_type='".GET_DISABLED."' WHERE user_id = '".$_GET['Disable_reporter']."'";
				pg_query(db_connect(), $updateAgent);
			}
			
			//Removes their favourites
			$getFavourites = pg_query(db_connect(), "SELECT * FROM reports JOIN users ON reports.user_id = users.user_id JOIN people ON users.user_id = people.user_id WHERE reports.user_id='".$_GET['Disable_reporter']."' LIMIT 200");
			while($runrows = pg_fetch_assoc($getFavourites))
			{
				$user_id = $runrows['user_id'];
				$listing_id = $runrows['listing_id'];
				$date = $runrows['reported_on'];
				$firstNameReport = $runrows['first_name'];
				$lastNameReport = $runrows['last_name'];
				
				$insertSQL = "DELETE FROM favourites WHERE user_id ='".$_GET['Disable_reporter']."' AND listing_id ='".$listing_id."';";
				pg_query(db_connect(), $insertSQL);
			}
			
			$getReports = pg_query(db_connect(), "SELECT * FROM reports JOIN users ON reports.user_id = users.user_id JOIN people ON users.user_id = people.user_id WHERE reports.user_id='".$_GET['Disable_reporter']."' LIMIT 200");
			while($runrows = pg_fetch_assoc($getReports))
			{
				$user_id = $runrows['user_id'];
				$listing_id = $runrows['listing_id'];
				$date = $runrows['reported_on'];
				$firstNameReport = $runrows['first_name'];
				$lastNameReport = $runrows['last_name'];
				
				$close = "UPDATE reports SET status='".CLOSED."' WHERE user_id='". $_GET['Disable_reporter']."'";
				pg_query(db_connect(), $close);
			}
			header("Location: admin.php");
		}
		
		
		
		//SQL code to get users that are pending to be agents
		$sql = "select * from users join people on users.user_id = people.user_id where users.user_type='P' ORDER BY users.user_id DESC";
			$result = pg_query(db_connect(), $sql ." LIMIT 200 ");
			$records = pg_num_rows($result);

		echo "<br/><br/>";

		
		
		
		$search = $sql;


			$search_exploded = explode (" ", $search);
			 
			$x = "";
			$construct = $sql;  
			    
			foreach($search_exploded as $search_each)
			{
				$x++;
				if($x==1)
					$construct .="title LIKE '%$search_each%'";
				else
					$construct .="AND title LIKE '%$search_each%'";  
			}
			 //USED TO MAKE THE NUMBER OF PAGINATE 
			$constructs = $sql;/*"SELECT * FROM listings 
					WHERE 1 = 1 AND (listings.city = 4 OR listings.city = 8 OR listings.city = 64) 
					AND (listings.bedrooms = 16 OR listings.bedrooms = 32) 
					AND (listings.property_type = 2 OR listings.property_type = 8 OR listings.property_type = 128) 
					AND listings.price >= 125000 AND listings.price <= 900000 
					AND listings.status = 'O' ORDER BY listings.listing_id";*/
					//echo $constructs;
			$run = pg_query(db_connect(),$constructs);
			    
			$foundnum = pg_num_rows($run);
			   
			//Shows the number of results match the criteria
			echo "<h2 align=\"center\">Show Pending Agents </h2>";
			//echo "<p>$foundnum results found !<p>";
			
			
			//Set up the query
			$getquery = pg_query(db_connect(), $sql. "");
			//echo $_SESSION['Where']. " ORDER BY listings.listing_id DESC LIMIT $per_page OFFSET $start <br>";  
			
			echo "<form action=\"$actual_link\" method=\"post\">";
			//_______________________________________________________________________________________________________CREATES THE DISABLED TABLE
			echo "\n<table border=\"0\">";
			$i=0;
			if ($i == 0)
			{
				echo "<tr><th>User ID</th><th>Full Name</th><th>Accept User</th><th>Disable User</th></tr>";
			}
			while($runrows = pg_fetch_assoc($getquery))
			{
				$user_id = $runrows['user_id'];
				$firstName = $runrows['first_name'];
				$lastName = $runrows['last_name'];
				
				$i +=1;
				echo "\n<tr><td> ";
				echo "$user_id";
				echo "\n</td>";
				echo "\n<td>";
				
				echo "<br/>$firstName $lastName ";	
				echo "\n</td> \n\t\t<td> <a class=\"homelist\" href=\"admin.php?Accept_user=$user_id\" > Accept </a> </td>";
				echo "<td> <a class=\"homelist\" href=\"admin.php?Disable_user=$user_id\" > Disable </a> </td> </tr>";
				echo "\n<tr><td colspan=\"4\">";
				echo "\n\t<hr/>";
				echo "\n</td></tr>";
			}
			
			echo "\n</table>";
				  
			
				  
			//Shows the number of results match the criteria
			echo "<br/><h2 align=\"center\">Show Reported Lists </h2>";
			//echo "<p>$foundnum results found !<p>";
			
			
			//Set up the query
			$getReports = pg_query(db_connect(), "SELECT * FROM reports JOIN users ON reports.user_id = users.user_id JOIN people ON users.user_id = people.user_id WHERE status='".OPEN."' ORDER BY reports.reported_on");
			
			//_______________________________________________________________________________________________________CREATES THE REPORTED TABLE
			echo "\n<table border=\"0\">";
			$i=0;
			if ($i == 0)
			{
				echo "<tr><th>Time Reported</th><th>Listing ID</th><th>User ID</th><th>Reporter's Name</th><th>Visit Listing</th><th>Disable Reporter</th></tr>";
			}
			while($runrows = pg_fetch_assoc($getReports))
			{
				$user_id = $runrows['user_id'];
				$listing_id = $runrows['listing_id'];
				$date = $runrows['reported_on'];
				$firstNameReport = $runrows['first_name'];
				$lastNameReport = $runrows['last_name'];
				
				$i +=1;
				echo "\n<tr><td> ";
				echo " $date";
				echo "\n</td>";
				echo "\n<td>";
				
				echo "<br/>$listing_id </td> <td>$user_id </td><td> $firstNameReport $lastNameReport ";	
				echo "\n</td> \n\t\t<td><a class=\"homelist\" href=\"listing-view.php?submit=Search+source+code&amp;listing_id=$listing_id\" > Visit </a> </td>";
				echo "<td> <a class=\"homelist\" href=\"admin.php?Disable_reporter=$user_id\" > Disable </a> </td> </tr>"; 
				echo "\n<tr><td colspan=\"6\">";
				echo "\n\t<hr/>";
				echo "\n</td></tr>";
			}
			
			echo "\n</table>";
				
		echo "</form>";
		echo "</div>
			</div>
		</section>";
		
		
		
		
		
	} else 
	{
		header("Location: /");
	}
	?>
<?php include 'footer.php'; ?>
