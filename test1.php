<?php
/*
Group 13
September 29, 2016
WEBD3201
The Welcome Page
*/
$title = "Search Matches";
$date = "November 06, 2016";
$filename = "listing-matches.php";
$description = " It shows any matched information";
include("header.php");
?>

<br/>

<form action='listing-matches.php' method='GET'>
<center>
<h1>My Search Engine</h1>
<input type='text' size='90' name='search'><br/><br/>
<input type='submit' name='submit' value='Search source code' ><br/><br/><br/>
</center>
</form>

<?php
	if (isset($_POST['formDoor']))
	{
		$aDoor = $_POST['formDoor'];
	}
	else
	{
		$aDoor = array();
	}
?>

<form action="test1.php" method="post">
 
Which buildings do you want access to?<br />
<input type="checkbox" name="formDoor[]" value="A" <?php echo (in_array("A", $aDoor)) ? "checked": ""; ?>/>Acorn Building<br />
<input type="checkbox" name="formDoor[]" value="B" <?php echo (in_array("B", $aDoor)) ? "checked": ""; ?>/>Brown Hall<br />
<input type="checkbox" name="formDoor[]" value="C" <?php echo (in_array("C", $aDoor)) ? "checked": ""; ?>/>Carnegie Complex<br />
<input type="checkbox" name="formDoor[]" value="D" <?php echo (in_array("D", $aDoor)) ? "checked": ""; ?>/>Drake Commons<br />
<input type="checkbox" name="formDoor[]" value="E" <?php echo (in_array("E", $aDoor)) ? "checked": ""; ?>/>Elliot House
 
<input type="submit" name="submit" value="Submit" />
 
</form>

<?php
  if(!isset($aDoor)) 
  {
    echo("You didn't select any buildings.");
  } 
  else
  {
    $N = count($aDoor);
 
    echo("You selected $N door(s): ");
    for($i=0; $i < $N; $i++)
    {
      echo($aDoor[$i] . " ");
    }
  }
?>
<form action="test1.php" method="post">
<?php
//--------------------------------------------------------------------------WASH
$wash_table = 'washrooms';
echo "<BR>$wash_table <br>";
	
	
	//If the page is load and there is a cookie set, it would choose the first option
	if (isset($_COOKIE['washroom_search']) && !isset($_POST[$wash_table]))
	{
		$wash = unserialize($_COOKIE['washroom_search']);
	}
	else if (isset($_POST[$wash_table])) //Once the user presses submit button
	{
		$wash = $_POST[$wash_table];
		setcookie("washroom_search", serialize($_POST[$wash_table]), time()+ COOKIE_LENGTH, "/");
	}
	else //If browser has neither cookies or options set up before
	{
		$wash = array();
	}
	
  echo build_checkbox($wash_table, $wash);
  
  //--------------------------------------------------------------------------BED
  $bed_table = 'bedrooms';
  echo "<BR>$bed_table <br>";
  
	//If the page is load and there is a cookie set, it would choose the first option
	if (isset($_COOKIE['bed_search']) && !isset($_POST[$wash_table]))
	{
		$beds = unserialize($_COOKIE['bed_search']);
		
	}
	else if (isset($_POST[$bed_table])) //Once the user presses submit button
	{
		$beds = $_POST[$bed_table];
		setcookie("bed_search", serialize($_POST[$bed_table]), time()+ COOKIE_LENGTH, "/");
	}
	else //If browser has neither cookies or options set up before
	{
		$beds = array();
	}
	
  echo build_checkbox($bed_table, $beds);
  //--------------------------------------------------------------------------PROPERTY_Test
  $propertyType_table = 'property_type';
  echo "<BR>$propertyType_table <br>";
  
  if (isset($_POST[$propertyType_table]))
	{
		$property_type = $_POST[$propertyType_table];
		
	}
	else
	{
		$property_type = array();
	}
	
  echo build_checkbox($propertyType_table, $property_type);
  
?>
<input type="submit" name="formSubmit" value="Submit" />
 
<?php 
	$sqlPrepare = ""; // main sequence code
	$where = ""; // if it doesn't start with a where yet
	$start = true; //used to check if there has already been a where statement
	
	//----------------------------------------------------------------------------------------------------------------------WASHROOM
	$sql = 'SELECT * FROM '.$wash_table;
	$result = pg_query(db_connect(), $sql);
	$records = pg_num_rows($result);
	for($i = 0; $i < $records; $i++)
	{
		if (in_array(pg_fetch_result($result, $i, "value"), $wash))
		{
			if (empty($where)) //Checks if where is empty
			{
				$where = "WHERE";
			}
			if (!isset($sql_bath)) //checks if sequence doesn't exist
			{
				$sql_bath = $where." (bathrooms = ". pg_fetch_result($result, $i, "value"). " ";
			}
			else if(isset($sql_bath)) //if it does exist
			{
				//$checked = (in_array(pg_fetch_result($result, $i, "value"), $wash)) ? pg_fetch_result($result, $i, "value"): "";
				$sql_bath .= "OR bathrooms = ". pg_fetch_result($result, $i, "value"). " ";
			}
			$start = false; //
		}
			
		
	} 
	if (isset($sql_bath))// adds a end bracket after the sequence is finished
	{
		$sql_bath .= ") ";

		echo "<br/>$sql_bath";
		$sqlPrepare = $sql_bath; // main sequence to be used
		//echo " <br/>SEQUENCE: $sqlPrepare";
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------BEDS
	$sql = 'SELECT * FROM '.$bed_table;
	$result = pg_query(db_connect(), $sql);
	$records = pg_num_rows($result);
	
	for($i = 0; $i < $records; $i++)
	{
		if (in_array(pg_fetch_result($result, $i, "value"), $beds))
		{
			if (empty($where) && ($start == true))//if the choices beforehand wasn't chosen, it would start a where
			{
				$where = "WHERE";
				
			}
			if (!isset($sql_beds) && ($start == true)) //Sets up the where in front of the criterias
			{
				$sql_beds = $where." (bedrooms = ". pg_fetch_result($result, $i, "value"). " ";
			}
			else if(!isset($sql_beds)) //Starts AND, if there options beforhand had WHERE started
			{
				$sql_beds = "AND (bedrooms = ". pg_fetch_result($result, $i, "value"). " ";
			}
			else if(isset($sql_beds)) //adds OR before the next criteria is entered
			{
				$sql_beds .= "OR bedrooms = ". pg_fetch_result($result, $i, "value"). " ";
			}
			$start = false;//Makes sure WHERE start once
		}
			
		
	}
	if (isset($sql_beds))
	{
		$sql_beds .= ") ";
		$sqlPrepare .= $sql_beds;
	}	
	if(isset($sql_beds))
	{
		echo "<br/>$sql_beds";
	}
	
	//--------------------------------------------------------------------------------------------------------------------------property_type
	$sql = 'SELECT * FROM '.$propertyType_table;
	$result = pg_query(db_connect(), $sql);
	$records = pg_num_rows($result);
	
	for($i = 0; $i < $records; $i++)
	{
		if (in_array(pg_fetch_result($result, $i, "value"), $property_type))
		{
			if (empty($where) && ($start == true))//if the choices beforehand wasn't chosen, it would start a where
			{
				$where = "WHERE";
				
			}
			if (!isset($sql_proType) && ($start == true)) //Sets up the where in front of the criterias
			{
				$sql_proType = $where." (property_type = ". pg_fetch_result($result, $i, "value"). " ";
			}
			else if(!isset($sql_proType)) //Starts AND, if there options beforhand had WHERE started
			{
				$sql_proType = "AND (property_type = ". pg_fetch_result($result, $i, "value"). " ";
			}
			else if(isset($sql_proType)) //adds OR before the next criteria is entered
			{
				$sql_proType .= "OR property_type = ". pg_fetch_result($result, $i, "value"). " ";
			}
			$start = false;//Makes sure WHERE start once
		}
			
		
	}
	if (isset($sql_proType))
	{
		$sql_proType .= ") ";
		$sqlPrepare .= $sql_proType;
	}	
	if(isset($sql_proType))
	{
		echo "<br/>$sql_proType";
	}
	
	//echo "<BR><BR> $sqlPrepare" ;
	if (isset($sql_proType) || isset($sql_beds) || isset($sql_bath))
	{
		$_SESSION['tttt'] = 'SELECT * FROM listings ' .$sqlPrepare;
		
		echo "<BR><BR> ". $_SESSION['tttt'];
		
		/* header("refresh:5;url=listing-matches.php");
		ob_flush(); */
	}
	?> 
</form>

<br/>
<?php include 'footer.php'; ?>