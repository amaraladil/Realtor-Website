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
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] == GET_AGENT) 
{
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if (isset($_SESSION['ShowMore']) )
		{
		$check = ($_SESSION['ShowMore']=='checked=true' )? 'checked=true': '';
		}
		else
		{
			$check="";
		}
	}
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$check = (isset($_POST['chkShowMore']) )? 'checked=true': '';
		$_SESSION['ShowMore'] = $check;
	}

	echo "<section class=\"content-body result\" id='result'>
			<div class=\"max-width body-place\">			
				<h2 class=\"title\">Welcome to the Agent's area, " . $_SESSION['username'] . "!</h2>
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
	echo "\n<br/> Primary Phone: ". display_phone_number($_SESSION['primary_phone'])."";
	echo "\n<br/> Secondary Phone: ". display_phone_number($_SESSION['secondary_phone'])."";
	echo "\n<br/> Fax Number: ". display_phone_number($_SESSION['fax'])."";
	echo "\n<br/> Preferred Contact Method: ".$_SESSION['contact_method']."";
	
	
	$per_page = PAGE_LIMIT;
	$start = isset($_GET['start']) ? $_GET['start']: 0;

	echo "\n<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" >";
	
	echo "<br/><br/><br/><center><input type=\"checkbox\" name=\"chkShowMore\" ".$check." value=\"1\">Show account's closed and hidden listings";
	
	echo "\n<br/><input type=\"submit\" name=\"submit\" value=\"Refresh\"/>";
	
	echo "\n\t</center>";
	
	//If there is session exist, it should put in the value for the checkbox
	if (isset($_SESSION['ShowMore']) )
	{
		$status = ($_SESSION['ShowMore']=='checked=true') ? "": "AND status='O'";
	}
	else
	{
		//Sets up the session for later use or enter
		$checked = "";
		$status = "AND status='O'";
		$_SESSION['ShowMore'] = "";
	}
	//SQL code
	$sql = "SELECT * FROM listings WHERE user_id='".$_SESSION['username']."' $status ORDER BY listings.listing_id DESC";
		$result = pg_query(db_connect(), $sql ." LIMIT 200 ");
		$records = pg_num_rows($result);

	echo "<br/><br/>";

	$search = $sql;
	if (isset($_GET ['submit']))
	{
		$button = $_GET ['submit'];
		$search = $sql; 
	}  

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
			echo "<h2 align=\"center\">Show current listings </h2>";
			//echo "<p>$foundnum results found !<p>";
			
			//sets the number of houses per pages
			$per_page = PAGE_LIMIT;
			$start = isset($_GET['start']) ? $_GET['start']: 0;
			
			//find the appropriate number of pages needed to display the page
			$max_pages = ceil($foundnum / $per_page);
			
			//Page starts at the first records
			if(!$start)
				$start=0; 
			
			//Set up the query
			$getquery = pg_query(db_connect(), $sql. " LIMIT $per_page OFFSET $start");
			//echo $_SESSION['Where']. " ORDER BY listings.listing_id DESC LIMIT $per_page OFFSET $start <br>";  
			
			//_______________________________________________________________________________________________________CREATES THE TABLE
			echo "\n<table border=\"0\">";
			$i=0;
			while($runrows = pg_fetch_assoc($getquery))
			{
				$listing_id = $runrows['listing_id'];
				$user_id = $runrows['user_id'];
				$city = $runrows['city'];
				$headline = $runrows['headline'];
				$description = $runrows['description'];
				$bed = $runrows['bedrooms'];
				$bath = $runrows['bathrooms'];
				$price = $runrows['price'];
				$property = $runrows['property_type'];
				$garage = $runrows['garage'];
				$schools = $runrows['schools'];
				$image = $runrows['images'];
				if ($i == 0)
				{
					echo "<tr><th>Listing ID</th><th>Headline</th><th>Edit</th></tr>";
				}
				$i +=1;
				echo "\n<tr><td> ";
				echo "$listing_id";
				echo "\n</td>";
				echo "\n<td align=\"left\">";
				
				echo "<br/><b><a class=\"homelist\" href=\"listing-view.php?submit=Search+source+code&amp;listing_id=$listing_id\" >$headline  </a></b> ";	
				echo "\n</td> \n\t\t<td> <a href=\"listing-update.php?submit=Search+source+code&amp;listing_id=$listing_id\" >EDIT </a> </td> </tr>";
				echo "\n<tr><td colspan=\"3\">";
				echo "\n\t<hr/>";
				echo "\n</td></tr>";
			}
			
			echo "\n</table>";
			  
			//Pagination Starts
			echo "<center>";
			  
			$prev = $start - $per_page;
			$next = $start + $per_page;
			                       
			$adjacents = 3;
			$last = $max_pages - 1;
			  
			if($max_pages > 1)
			{   
			//previous button
			if (!($start<=0)) 
			echo " <a href='dashboard.php?submit=Search+source+code&amp;start=$prev'>Prev</a> ";    
			          
			//In the first 6 pages, it doesn't skip
			if ($max_pages < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
			{
				$i = 0;   
				for ($counter = 1; $counter <= $max_pages; $counter++)
				{
					if ($i == $start){
						echo " <a href='dashboard.php?submit=Search+source+code&amp;start=$i'><b>$counter</b></a> ";
					}
					else {
						echo " <a href='dashboard.php?submit=Search+source+code&amp;start=$i'>$counter</a> ";
					}  
					$i = $i + $per_page;                 
				}
			}
			elseif($max_pages > 5 + ($adjacents * 2))    //enough pages to hide some but the first two and the next 3 pages
			{
				//close to beginning; only hide later pages
				if(($start/$per_page) < 1 + ($adjacents * 2))        
				{
					$i = 0;
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($i == $start){
							echo " <a href='dashboard.php?submit=Search+source+code&amp;start=$i'><b>$counter</b></a> ";
						}
						else {
							echo " <a href='dashboard.php?submit=Search+source+code&amp;start=$i'>$counter</a> ";
						} 
						$i = $i + $per_page;                                       
					}
				                          
				}
				//in middle; hide some front and some back
				elseif($max_pages - ($adjacents * 2) > ($start / $per_page) && ($start / $per_page) > ($adjacents * 2))
				{
					echo " <a href='dashboard.php?submit=Search+source+code&amp;start=0'>1</a> ";
					echo " <a href='dashboard.php?submit=Search+source+code&amp;start=$per_page'>2</a> .... ";
					 
					$i = $start;                 
					for ($counter = ($start/$per_page)+1; $counter < ($start / $per_page) + $adjacents + 2; $counter++)
					{
						if ($i == $start){
						echo " <a href='dashboard.php?submit=Search+source+code&amp;start=$i'><b>$counter</b></a> ";
						}
						else {
						echo " <a href='dashboard.php?submit=Search+source+code&amp;start=$i'>$counter</a> ";
						}   
						$i = $i + $per_page;                
					}
					
				}
				//close to end; only hide early pages
				else
				{
					echo " <a href='dashboard.php?submit=Search+source+code&amp;start=0'>1</a> ";
					echo " <a href='dashboard.php?submit=Search+source+code&amp;start=$per_page'>2</a> .... ";
					 
					$i = $start;                
					for ($counter = ($start / $per_page) + 1; $counter <= $max_pages; $counter++)
					{
					if ($i == $start){
					echo " <a href='dashboard.php?submit=Search+source+code&amp;start=$i'><b>$counter</b></a> ";
					}
					else {
					echo " <a href='dashboard.php?submit=Search+source+code&amp;start=$i'>$counter</a> ";   
					} 
					$i = $i + $per_page;              
					}
				}
			}
		          
			//next button
			if (!($start >=$foundnum-$per_page))
				echo " <a href='dashboard.php?submit=Search+source+code&amp;start=$next'>Next</a> ";    
			} 
			echo "</center>";
	echo "</form>";
	echo "</div>
	</div>
</section>";
}
else
{
	header("Location: /");
}
?>
<?php include 'footer.php'; ?>
