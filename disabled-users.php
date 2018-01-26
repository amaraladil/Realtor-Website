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
		
		//SQL code
		$sql = "SELECT * FROM users JOIN people ON users.user_id = people.user_id WHERE user_type='".GET_DISABLED."' ORDER BY users.user_id ";
			$result = pg_query(db_connect(), $sql. " LIMIT 200 ");
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
			$constructs = $sql;
			
			$run = pg_query(db_connect(),$constructs);
			    
			$foundnum = pg_num_rows($run);
			   
				//Shows the number of results match the criteria
				echo "<h2 align=\"center\">Show Disabled Users </h2>";
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
				
				//_______________________________________________________________________________________________________CREATES THE TABLE
				echo "\n<table border=\"0\">";
				$i=0;
				if ($i == 0)
				{
					echo "<tr><th>User ID</th><th>Full Name</th></tr>";
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
					echo "\n<td >";
					
					echo "<br/>$firstName $lastName ";	
					echo "\n </tr>";
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
				echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=$prev'>Prev</a> ";    
				          
				//In the first 6 pages, it doesn't skip
				if ($max_pages < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
				{
					$i = 0;   
					for ($counter = 1; $counter <= $max_pages; $counter++)
					{
						if ($i == $start){
							echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=$i'><b>$counter</b></a> ";
						}
						else {
							echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=$i'>$counter</a> ";
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
								echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=$i'><b>$counter</b></a> ";
							}
							else {
								echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=$i'>$counter</a> ";
							} 
							$i = $i + $per_page;                                       
						}
					                          
					}
					//in middle; hide some front and some back
					elseif($max_pages - ($adjacents * 2) > ($start / $per_page) && ($start / $per_page) > ($adjacents * 2))
					{
						echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=0'>1</a> ";
						echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=$per_page'>2</a> .... ";
						 
						$i = $start;                 
						for ($counter = ($start/$per_page)+1; $counter < ($start / $per_page) + $adjacents + 2; $counter++)
						{
							if ($i == $start){
							echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=$i'><b>$counter</b></a> ";
							}
							else {
							echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=$i'>$counter</a> ";
							}   
							$i = $i + $per_page;                
						}
						
					}
					//close to end; only hide early pages
					else
					{
						echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=0'>1</a> ";
						echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=$per_page'>2</a> .... ";
						 
						$i = $start;                
						for ($counter = ($start / $per_page) + 1; $counter <= $max_pages; $counter++)
						{
						if ($i == $start){
						echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=$i'><b>$counter</b></a> ";
						}
						else {
						echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=$i'>$counter</a> ";   
						} 
						$i = $i + $per_page;              
						}
					}
				}
			          
				//next button
				if (!($start >=$foundnum-$per_page))
					echo " <a href='disabled-users.php?submit=Search+source+code&amp;start=$next'>Next</a> ";    
				} 
				echo "</center>";
		echo "</form>";
		echo "<br/>";
		
		
		
		
	}
	?>
<?php include 'footer.php'; ?>