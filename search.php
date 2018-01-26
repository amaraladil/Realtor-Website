<?php
    require("./includes/constants.php");
	require("./includes/functions.php");
	require("./includes/db.php");
//http://www.findsourcecode.com/php/pagination-in-search-engine/
	
$button = $_GET ['submit'];
$search = $_GET ['search']; 
  
if(strlen($search)<=1)
	echo "Search term too short";
else
{
	echo "You searched for <b>$search</b> <hr size='1'></br>";

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
	  
	$constructs = "SELECT * FROM listings";
	$run = pg_query(db_connect(),$constructs);
	    
	$foundnum = pg_num_rows($run);
	    
	if ($foundnum==0)
	echo "Sorry, there are no matching result for <b>$search</b>.</br></br>1. 
	Try more general words. for example: If you want to search 'how to create a website'
	then use general keyword like 'create' 'website'</br>2. Try different words with similar
	 meaning</br>3. Please check your spelling";
	else
	{ 
		  
		echo "$foundnum results found !<p>";
		  
		$per_page = 10;
		$start = isset($_GET['start']) ? $_GET['start']: 0;
		//echo $start;
		$max_pages = ceil($foundnum / $per_page);
		if(!$start)
		$start=0; 
		$getquery = pg_query(db_connect(), "SELECT * FROM listings ORDER BY listings.listing_id DESC LIMIT 10 OFFSET $start");
		echo "SELECT * FROM listings ORDER BY listings.listing_id DESC LIMIT 10 OFFSET $start <br>";  
		$i = 1;
		echo "\n<table>";
		echo "\n<tr><th>TEST</th></tr>";
		
		while($runrows = pg_fetch_assoc($getquery))
		{
			$listing_id = $runrows['listing_id'];
			$user_id = $runrows['user_id'];
			$title = $runrows['city'];
			$headline = $runrows['headline'];
			$description = $runrows['description'];
			$bed = $runrows['bedrooms'];
			$bath = $runrows['bathrooms'];
			
			echo "\n<tr><td>";
			echo $i;	
			echo "<br/>LISTING ID: $listing_id
			<br/>USER: $user_id
			<br/>HEADLINE:$headline
			<br/>DESCRIPTION: $description
			<br/>LOCATION: ".get_property('cities',$title)." # $title</b>
			<br/>Bedroom: ".	get_property('bedrooms',$bed).
			"<br/>Bathroom: ".	get_property('washrooms',$bath).
			"";
		    $i +=1;
			echo "\n</td></tr>";
		}
		
		echo "\n</table>";
		//print_r(array_values($runrows));
		  
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
		echo " <a href='search.php?search=$search&submit=Search+source+code&start=$prev'>Prev</a> ";    
		          
		//pages 
		if ($max_pages < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
		{
			$i = 0;   
			for ($counter = 1; $counter <= $max_pages; $counter++)
			{
				if ($i == $start){
					echo " <a href='search.php?search=$search&submit=Search+source+code&start=$i'><b>$counter</b></a> ";
				}
				else {
					echo " <a href='search.php?search=$search&submit=Search+source+code&start=$i'>$counter</a> ";
				}  
				$i = $i + $per_page;                 
			}
		}
		elseif($max_pages > 5 + ($adjacents * 2))    //enough pages to hide some
		{
			//close to beginning; only hide later pages
			if(($start/$per_page) < 1 + ($adjacents * 2))        
			{
				$i = 0;
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($i == $start){
						echo " <a href='search.php?search=$search&submit=Search+source+code&start=$i'><b>$counter</b></a> ";
					}
					else {
						echo " <a href='search.php?search=$search&submit=Search+source+code&start=$i'>$counter</a> ";
					} 
					$i = $i + $per_page;                                       
				}
			                          
			}
			//in middle; hide some front and some back
			elseif($max_pages - ($adjacents * 2) > ($start / $per_page) && ($start / $per_page) > ($adjacents * 2))
			{
				echo " <a href='search.php?search=$search&submit=Search+source+code&start=0'>1</a> ";
				echo " <a href='search.php?search=$search&submit=Search+source+code&start=$per_page'>2</a> .... ";
				 
				$i = $start;                 
				for ($counter = ($start/$per_page)+1; $counter < ($start / $per_page) + $adjacents + 2; $counter++)
				{
					if ($i == $start){
					echo " <a href='search.php?search=$search&submit=Search+source+code&start=$i'><b>$counter</b></a> ";
					}
					else {
					echo " <a href='search.php?search=$search&submit=Search+source+code&start=$i'>$counter</a> ";
					}   
					$i = $i + $per_page;                
				}
				
			}
			//close to end; only hide early pages
			else
			{
				echo " <a href='search.php?search=$search&submit=Search+source+code&start=0'>1</a> ";
				echo " <a href='search.php?search=$search&submit=Search+source+code&start=$per_page'>2</a> .... ";
				 
				$i = $start;                
				for ($counter = ($start / $per_page) + 1; $counter <= $max_pages; $counter++)
				{
				if ($i == $start){
				echo " <a href='search.php?search=$search&submit=Search+source+code&start=$i'><b>$counter</b></a> ";
				}
				else {
				echo " <a href='search.php?search=$search&submit=Search+source+code&start=$i'>$counter</a> ";   
				} 
				$i = $i + $per_page;              
				}
			}
		}
	          
		//next button
		if (!($start >=$foundnum-$per_page))
		echo " <a href='search.php?search=$search&submit=Search+source+code&start=$next'>Next</a> ";    
		}   
		echo "</center>";
	} 
} 
?>