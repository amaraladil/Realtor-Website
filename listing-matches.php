<?php
/*
Group 13
November 10, 2016
WEBD3201
The list match result page
*/
$title = "Search Matches";
$date = "November 06, 2016";
$filename = "listing-matches.php";
$description = " It shows any matched information";
include("header.php");
?>

<br/>
<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION['previousPage'] = $actual_link;
//http://www.findsourcecode.com/php/pagination-in-search-engine/

if (isset($_SESSION['Where'])) //_________________checks if statement was created
{
	$search = $_SESSION['Where'];
}
else
{
	echo "You will be redirected to be able to the search page";
	header("refresh:5;url=listing-cities.php");
}

if (isset($_GET ['submit']))
{
	$button = $_GET ['submit'];
	$search = $_SESSION['Where']; 
}  
if(strlen($search)<=1)
	echo "Search term too short";
else
{

	$search_exploded = explode (" ", $search);
	 
	$x = "";
	$construct = "";  
	    
	foreach($search_exploded as $search_each)
	{
		$x++;
		if($x==1)
			$construct .="title LIKE '%$search_each%'";
		else
			$construct .="AND title LIKE '%$search_each%'";  
	}
	 //USED TO MAKE THE NUMBER OF PAGINATE 
	$constructs = $_SESSION['Where'] . " ORDER BY listings.listing_id LIMIT 200";/*"SELECT * FROM listings 
			WHERE 1 = 1 AND (listings.city = 4 OR listings.city = 8 OR listings.city = 64) 
			AND (listings.bedrooms = 16 OR listings.bedrooms = 32) 
			AND (listings.property_type = 2 OR listings.property_type = 8 OR listings.property_type = 128) 
			AND listings.price >= 125000 AND listings.price <= 900000 
			AND listings.status = 'O' ORDER BY listings.listing_id";*/
			//echo $constructs;
	$run = pg_query(db_connect(),$constructs);
	    
	$foundnum = pg_num_rows($run);
	    
	if ($foundnum==0) // IF no matches are found
	echo "Sorry, there are no matching result for your critera<br/>";
	 
	else if ($foundnum==1) //REDIRECTS THE USER TO THE LISTING VIEW PAGE
	{
		$listing_id = pg_fetch_result($run, 0, "listing_id");
		echo "You found one";
		header("Location: listing-view.php?submit=Search+source+code&listing_id=$listing_id");
	}
	else
	{ 
		//Shows the number of results match the criteria
		echo "$foundnum results found !<p>";
		
		//sets the number of houses per pages
		$per_page = PAGE_LIMIT;
		$start = isset($_GET['start']) ? $_GET['start']: 0;
		
		//find the appropriate number of pages needed to display the page
		$max_pages = ceil($foundnum / $per_page);
		
		//Page starts at the first records
		if(!$start)
			$start=0; 
		
		//Set up the query
		$getquery = pg_query(db_connect(), $_SESSION['Where']. " ORDER BY listings.listing_id DESC LIMIT $per_page OFFSET $start");
		//echo $_SESSION['Where']. " ORDER BY listings.listing_id DESC LIMIT $per_page OFFSET $start <br>";  
		
		//_______________________________________________________________________________________________________CREATES THE TABLE
		echo "\n<table border=\"0\">";
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
			
			echo "\n<tr><td>";//IMAGE LOAD SECTION
			if (file_exists("./listing/$listing_id/".$listing_id."_".$image.".jpg")) 
			{
			    echo "<img src=\"./listing/$listing_id/".$listing_id."_".$image.".jpg\" alt=\"House Image\" width=\"300px\"/>";
			}
			else
			{
				echo "<img src=\"images/notFound.jpg\" alt=\"Image Not Found\" width=\"300px\" />";
			}
			echo "\n</td>";
			echo "\n<td align=\"left\">";
			
			//THE INFORMATION OF THE HOUSE
			echo "<br/><b><a class=\"homelist\" href=\"listing-view.php?submit=Search+source+code&amp;listing_id=$listing_id\" >$headline </b> </a>
			<br/>BUILDING TYPE: ".	get_property('property_type',$property)."
			<br/>Bedroom: ".	get_property('bedrooms',$bed) . "
			<br/>Bathroom: ".	get_property('washrooms',$bath). " 
			<br/>LOCATION: ".get_property('cities',$city)." 
			
			<br/>PRICE: $".	number_format($price,2) . " ";	
			echo "\n</td></tr>";
			echo "\n<tr><td colspan=\"2\">";
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
		echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=$prev'>Prev</a> ";    
		          
		//In the first 6 pages, it doesn't skip
		if ($max_pages < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
		{
			$i = 0;   
			for ($counter = 1; $counter <= $max_pages; $counter++)
			{
				if ($i == $start){
					echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=$i'><b>$counter</b></a> ";
				}
				else {
					echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=$i'>$counter</a> ";
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
						echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=$i'><b>$counter</b></a> ";
					}
					else {
						echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=$i'>$counter</a> ";
					} 
					$i = $i + $per_page;                                       
				}
			                          
			}
			//in middle; hide some front and some back
			elseif($max_pages - ($adjacents * 2) > ($start / $per_page) && ($start / $per_page) > ($adjacents * 2))
			{
				echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=0'>1</a> ";
				echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=$per_page'>2</a> .... ";
				 
				$i = $start;                 
				for ($counter = ($start/$per_page)+1; $counter < ($start / $per_page) + $adjacents + 2; $counter++)
				{
					if ($i == $start){
					echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=$i'><b>$counter</b></a> ";
					}
					else {
					echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=$i'>$counter</a> ";
					}   
					$i = $i + $per_page;                
				}
				
			}
			//close to end; only hide early pages
			else
			{
				echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=0'>1</a> ";
				echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=$per_page'>2</a> .... ";
				 
				$i = $start;                
				for ($counter = ($start / $per_page) + 1; $counter <= $max_pages; $counter++)
				{
				if ($i == $start){
				echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=$i'><b>$counter</b></a> ";
				}
				else {
				echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=$i'>$counter</a> ";   
				} 
				$i = $i + $per_page;              
				}
			}
		}
	          
		//next button
		if (!($start >=$foundnum-$per_page))
		echo " <a href='listing-matches.php?submit=Search+source+code&amp;start=$next'>Next</a> ";    
		}   
		echo "</center>";
	} 
} 
?>


<br/>
<?php include 'footer.php'; ?>