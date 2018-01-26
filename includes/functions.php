<?php
/*
Group 13
September 29, 2016
--WEBD3201
*/
function displayCopyright()
{
	echo "&copy; JTAS Inc. ". date('Y');
}

function display_phone_number($phone)
{
    $phone = preg_replace("/[^0-9]/", "", $phone);

    if(strlen($phone) == 7)
	{
        return preg_replace("/(\d{3})(\d{4})/", "$1-$2", $phone);
    }
	elseif(strlen($phone) == 10)
	{
        return preg_replace("/(\d{3})(\d{3})(\d{4})/", "($1) $2-$3", $phone);
	}
	elseif(strlen($phone) == 15)
	{
        return preg_replace("/(\d{3})(\d{3})(\d{4})/", "($1) $2-$3 ext.$4", $phone);
	}
    else
	{
        return $phone;
	}
}
//Got this code from: http://www.pixelenvision.com/1708/zip-postal-code-validation-regex-php-code-for-12-countries/
function is_valid_postal_code($postal) 
{
	$regex = "^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ])\ {0,1}(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$";
	if (!preg_match("/".$regex."/i",$postal))
	{
		return true;
	} else 
	{
		return false;
	}
}

/*
	this function should be passed a integer power of 2, and any decimal number,
	it will return true (1) if the power of 2 is contain as part of the decimal argument
*/
function isBitSet($power, $decimal) {
	if((pow(2,$power)) & ($decimal)) 
		return 1;
	else
		return 0;
} 

/*
	this function can be passed an array of numbers (like those submitted as 
	part of a named[] check box array in the $_POST array).
*/
function sumCheckBox($array)
{
	$num_checks = count($array); 
	$sum = 0;
	for ($i = 0; $i < $num_checks; $i++)
	{
	  $sum += $array[$i]; 
	}
	return $sum;
}

function makeWhereStatement($table, $selectedValue, $fieldName)
{
	$sql = 'SELECT * FROM '.$table;
	$result = pg_query(db_connect(), $sql);
	$records = pg_num_rows($result);
	
	for($i = 0; $i < $records; $i++)
	{
		if (isBitSet($i, $selectedValue))
		{
			if (empty($where) && ($_SESSION['WhereStarted'] == true))//if the choices beforehand wasn't chosen, it would start a where
			{
				$where = "WHERE";
			}
			if (!isset($sql_table) && ($_SESSION['WhereStarted'] == true)) //Sets up the where in front of the criterias
			{
				$sql_table = $where." ($fieldName = ". pg_fetch_result($result, $i, "value"). " ";
			}
			else if(!isset($sql_table)) //Starts AND, if there options beforhand had WHERE started
			{
				$sql_table = "AND ($fieldName = ". pg_fetch_result($result, $i, "value"). " ";
			}
			else if(isset($sql_table)) //adds OR before the next criteria is entered
			{
				$sql_table .= "OR $fieldName = ". pg_fetch_result($result, $i, "value"). " ";
			}
			$_SESSION['WhereStarted'] = false;//Makes sure WHERE start once
		}
	}
	if (isset($sql_table))
	{
		$sql_table .= ") ";
		//$sqlPrepare .= $sql_table;
		//echo "<br/>$sql_table";
		return $sql_table;
	}
	else
	{
		return "";
	}
}

/*Function to make a random password for password request email*/
function randomPasswordGenerator() {
    $charecters = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); 
    $charectersLength = strlen($charecters) - 1; 
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $charectersLength);
        $pass[] = $charecters[$n];
    }
    return implode($pass); 
}


?>