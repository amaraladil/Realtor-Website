<?php
/*
Group 13
September 29, 2016
--WEBD3201
*/

//Login
pg_prepare(db_connect(), "Log_In_query", 'SELECT * FROM users WHERE user_id = $1 AND password = $2');
//Update users last login access
pg_prepare(db_connect(),"UpdateUserDate","UPDATE users SET last_access = '" . date("Y-m-d",time()) . "' WHERE user_id = $1");
//checks if username is found atleast but wrong password
pg_prepare(db_connect(), "user_check", 'SELECT * FROM users WHERE user_id = $1');
//INSERT NEW USER IN USERS TABLE
pg_prepare(db_connect(), "insert_user", 'INSERT INTO users VALUES($1, $2, $3, $4, $5, $6)');
//INSERT NEW USER IN PEOPLE TABLE
pg_prepare(db_connect(), "insert_people", 'INSERT INTO people VALUES($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13)');
//INSERT NEW LISTING IN TABLE
pg_prepare(db_connect(), "insert_listings", 'INSERT INTO listings VALUES($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18)');
// Updates user password
pg_prepare(db_connect(), "update_user_pass", 'UPDATE users SET password = $1 WHERE user_id = $2 AND password = $3');
//Get Personal
pg_prepare(db_connect(), "Get_Personal", 'SELECT * FROM people WHERE user_id = $1');
//Password change request
pg_prepare(db_connect(), "update_password_request", 'UPDATE users SET password = $1 WHERE user_id = $2 AND email_address = $3');
//Update Email/Users table
pg_prepare(db_connect(), "update_users", 'UPDATE users SET email_address = $1 WHERE user_id = $2');
//Update Peoples Table
pg_prepare(db_connect(), "update_people", 'UPDATE people SET  salutation = $1, first_name=$2, last_name=$3,  street_address_1 = $4, street_address_2=$5, city=$6, province=$7, postal_code=$8, primary_phone_number=$9, secondary_phone_number=$10, fax_number=$11, preferred_contact_method=$12  WHERE user_id = $13');
//Update Listing Images
pg_prepare(db_connect(), "update_image", 'UPDATE listings SET images=$1 WHERE listing_id=$2');
//Update Listing
pg_prepare(db_connect(), "update_listings", 'UPDATE listings SET status=$1, price=$2, headline=$3, description=$4, postal_code=$5, city=$6, property_options=$7, bedrooms=$8, bathrooms=$9, garage=$10, purchase_type=$11, property_type=$12, finished_basement=$13, open_house=$14, schools=$15 WHERE listing_id=$16');
//Get Listing Information
pg_prepare(db_connect(), "get_listing", 'SELECT * FROM listings WHERE listing_id=$1');


function db_connect()
{
	
	return pg_connect("host=".HOST_DB." dbname=".NAME_DB." user=".USER_DB." password=".PASSWORD_DB."" );  
}

function is_user_id($id)
{
	$result = pg_execute(db_connect(),"user_check",array($id));
	$records = pg_num_rows($result);
	if ( $records == 1)
	{
		return true;
	}
	else 
	{
		return false;
	}
}

function build_simple_dropdown($table,$selected)
{
	$sql = 'SELECT * FROM '.$table;
	$output = "";
	$result = pg_query(db_connect(), $sql);
	$records = pg_num_rows($result);
	$output .= "\n<select name = \"".$table."\">";
	$output .= "\n<option value = \"\"></option>";
	for($i = 0; $i < $records; $i++)
	{
		$checked = (pg_fetch_result($result, $i, "value") == $selected)? "selected":"";
		$output .= "\n<option value = '".pg_fetch_result($result, $i, "value")."' ".$checked." >".pg_fetch_result($result, $i, "value")."</option>";
		//$records['value']
	}
	$output .= "\n</select>";
	return $output;
}

function build_dropdown($table,$selected)
{
	$sql = 'SELECT * FROM '.$table;
	$output = "";
	$result = pg_query(db_connect(), $sql);
	$records = pg_num_rows($result);
	$output .= "\n<select name = \"".$table."\">";
	$output .= "\n<option value = \"\"></option>";
	for($i = 0; $i < $records; $i++)
	{
		$checked = (pg_fetch_result($result, $i, "value") == $selected)? "selected":"";
		$output .= "\n<option value = '".pg_fetch_result($result, $i, "value")."' ".$checked." >".pg_fetch_result($result, $i, "property")."</option>";
		//$records['value']
	}
	$output .= "\n</select>";
	return $output;
}

function build_radio($table,$selected)
{
	$sql = 'SELECT * FROM '.$table;
	$output = "";
	$result = pg_query(db_connect(), $sql);
	$records = pg_num_rows($result);
	for($i = 0; $i < $records; $i++){
		$checked = (pg_fetch_result($result, $i, "value") == $selected)? "checked":"";
		$output .= "\n<label><input type=\"radio\" name=\"".$table."\" value=\"".pg_fetch_result($result, $i, "value")."\" ".$checked."/><span>".pg_fetch_result($result, $i, "property")."</span></label>";		
	}
	return $output;
}

function get_property($table,$value)
{
	$sql = 'SELECT * FROM '.$table;
	$output = "";
	$result = pg_query(db_connect(), $sql);
	$records = pg_num_rows($result);
	for($i = 0; $i < $records; $i++)
	{ 
		$output .= (pg_fetch_result($result, $i, "value") == $value)? pg_fetch_result($result, $i, "property") :"";
		
	}
	return $output;
}

function build_checkbox($table,$preselected)
{
	$sql = 'SELECT * FROM '.$table;
	$output = "";
	$result = pg_query(db_connect(), $sql);
	$records = pg_num_rows($result);
	for($i = 0; $i < $records; $i++){
		$checked = isBitSet($i, $preselected)? " checked=\"checked\" ": "";
		$output .= "\n<label><input type=\"checkbox\" name=\"".$table."[]\" value=\"".pg_fetch_result($result, $i, "value")."\" ".$checked."/> <span> ".pg_fetch_result($result, $i, "property")."</span></label>";		
	}
	return $output;
}

?>