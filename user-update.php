<?php
/*
Group_13
November 21, 2016
WEBD3201
Update page
*/
$title = "Update";
$date = "November 21, 2016";
$filename = "Update.php";
$description = "The update page to update a users information";
include("header.php");
?>
<?php
$error = "";
$output = "";
if (!isset($_SESSION['loggedin']) )
{
	header("Location: login.php");
}


if($_SERVER["REQUEST_METHOD"] == "GET")
{
	
	//default mode when the page loads the first time
	//can be used to make decisions and initialize variables
	//User Table Fields
	$first = $_SESSION['first_name'] ;
	$last = $_SESSION['last_name'] ;
	$email = $_SESSION['email'];
	//People Table Fields
	$salutation = $_SESSION['salutation'];
	$provinces = $_SESSION['province'] ;
	$street = $_SESSION['street_address_1'] ;
	$secondStreet = $_SESSION['street_address_2'] ;
	$city = $_SESSION['city'] ;
	$postal = $_SESSION['postal_code'];
	$phone = $_SESSION['primary_phone'] ;
	$secondPhone = $_SESSION['secondary_phone'] ;
	$fax = $_SESSION['fax'] ;
	$selected_method = $_SESSION['contact_method'];	

	
	
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	
	//the page got here from submitting the form, let's try to process
	$first = trim($_POST["first"]); //the name of the input box on the form, white-space removed
	$last = trim($_POST["last"]); //the name of the input box on the form, white-space removed
	$email = trim($_POST["email"]); //the name of the input box on the form, white-space removed	
	//Peoples variables
	$salutation = trim($_POST['salutation']);
	$street = trim($_POST['street']);
	$secondStreet = trim($_POST['2ndStreet']);
	$city = trim($_POST['city']);
	$provinces = trim($_POST['provinces']);
	$postal = trim($_POST['postal']);
	$phone = trim($_POST['phone']);
	$secondPhone = trim($_POST['2ndPhone']);
	$fax = trim($_POST['fax']);
	$selected_method = "";
	
	//----------------------------------------------------------------------------------------------FIRST NAME
	if(!isset($first) || $first == "")
	{
		//means the user did not enter anything
		$error .= "First Name input is empty. <br/>";
	}
	else if (trim(strlen($first)) > MAX_FIRST_NAME_LENGTH)
	{
		$error .= "First Name input is more than the ".MAX_FIRST_NAME_LENGTH." limit<br/>";
	}
	else if (is_numeric($first))
	{
		$error .= "First Name (".$first.") cannot be a numeric<br/>";
		$first = "";
	}
	
	//----------------------------------------------------------------------------------------------LAST NAME
	if(!isset($last) || $last == "")
	{
		//means the user did not enter anything
		$error .= "Last Name is empty. <br/>";
	}
	else if (trim(strlen($last)) > MAX_LAST_NAME_LENGTH)
	{
		$error .= "Last Name input is more than the ".MAX_LAST_NAME_LENGTH." limit <br/>";
	}
	else if (is_numeric($last))
	{
		$error .= "Last Name (".$last.") cannot be a numeric<br/>";
		$last = "";
	}
	
	//----------------------------------------------------------------------------------------------EMAIL
	if(!isset($email) || $email == "")
	{
		//means the user did not enter anything
		$error .= "Email is empty. <br/>";
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$error .= "Email (".$email.") is not format properly (apple@pie.com) <br/>";
		$email = "";
	}
	//----------------------------------------------------------------------------------------------POSTAL CODE
	if(!isset($postal) || !($postal == ""))//if values are entered
	{
		//means the user did not enter anything
		if (trim(strlen($postal)) > MAXIMUM_POSTAL_LENGTH)
		{
			$error .= "Postal Code cannot be more than ".MAXIMUM_POSTAL_LENGTH." characters <br/>";
		}
		else if (is_valid_postal_code($postal))
		{
			$error .= "Postal Code (".$postal.") is not a valid Postal Code<br/>";
			$postal = "";
		}
		
	}
	
	//----------------------------------------------------------------------------------------------PHONE NUMBER
	if ( !isset($phone) || $phone == "")
	{
		
		if(!preg_match('/^[0-9]{3}[0-9]{3}[0-9]{4}$/', $phone))
		{
			$error .= "\n Phone Number have to have 10 numbers<br/>";
		}
		else if (substr($phone, 0,3) < MINIMUM_PHONE_LENGTH)
		{
			$error .= "\n Phone number area code must be ".MINIMUM_PHONE_LENGTH." or more<br/>";
		}
		else if (substr($phone, 3,3) < MINIMUM_PHONE_LENGTH)
		{
			$error .= "\n Phone number exchange code must be ".MINIMUM_PHONE_LENGTH." or more<br/>";
		}
	
	}
	//----------------------------------------------------------------------------------------------SECOND PHONE NUMBER
	if (!isset($secondPhone) || !$secondPhone == "")
	{
		if(!preg_match('/^[0-9]{3}[0-9]{3}[0-9]{4}$/', $secondPhone))
	    {
			$error .= "\n Phone Number have to have 10 numbers<br/>";
	    }
		else if (substr($secondPhone, 0,3) < MINIMUM_PHONE_LENGTH)
		{
		    $error .= "\n Phone number area code must be ".MINIMUM_PHONE_LENGTH." or more<br/>";
		}
		else if (substr($secondPhone, 3,3) < MINIMUM_PHONE_LENGTH)
		{
		    $error .= "\n Phone number exchange code must be ".MINIMUM_PHONE_LENGTH." or more<br/>";
		}
	}
	
	//----------------------------------------------------------------------------------------------FAX NUMBER
	if (!isset($fax) || !$fax == "")
	{
		if(!preg_match('/^[0-9]{3}[0-9]{3}[0-9]{4}$/', $fax))
	    {
			$error .= "\n Phone Number have to have 10 numbers<br/>";
	    }
		else if (substr($fax, 0,3) < MINIMUM_PHONE_LENGTH)
		{
		    $error .= "\n Phone number area code must be ".MINIMUM_PHONE_LENGTH." or more<br/>";
		}
		else if (substr($fax, 3,3) < MINIMUM_PHONE_LENGTH)
		{
		    $error .= "\n Phone number exchange code must be ".MINIMUM_PHONE_LENGTH." or more<br/>";
		}
	}
	
	//----------------------------------------------------------------------------------------------CONTACT METHOD
	if (isset($_POST['submit']) && isset($_POST['contact_method']))//Sets the variable
	{
		$selected_method = $_POST['contact_method'];
	}
	
	//if error is an empty string
	if($error == "")
	{  
		
		$output = "Successful Updated information";
		
		$_SESSION['first_name'] = $first ;
		$_SESSION['last_name'] = $last ;
		$_SESSION['email'] = $email;
		//People Table Fields
		$_SESSION['salutation'] = $salutation;
		$_SESSION['province'] = $provinces  ;
		$_SESSION['street_address_1'] = $street;
		$_SESSION['street_address_2'] = $secondStreet ;
		$_SESSION['city'] = $city ;
		$_SESSION['postal_code'] = $postal;
		$_SESSION['primary_phone'] = $phone;
		$_SESSION['secondary_phone'] =$secondPhone ;
		$_SESSION['fax'] = $fax;
		$_SESSION['contact_method'] = $selected_method;	
		
		pg_execute(db_connect(),"update_users",array($email,$_SESSION['username']) );
		pg_execute(db_connect(),"update_people",array($salutation,$first,$last,$street,$secondStreet,$city,$provinces,$postal,$phone,$secondPhone,$fax,$selected_method, $_SESSION['username']) );
	}
	
}
?>
<!-- form section start -->
<section class="content-body" id='formSetup'>
        <div class="max-width body-place">			
			<h2 class="title">Update Information Page</h2>			
			<h2 style="text-align: center;"><?php echo $output; ?></h2>
			<h3 style="text-align: center;"><?php echo $error; ?></h3>
			<h3 style="text-align: center;">Fill in fields you wish to update</h3>
			<h4 style="text-align: center;">&nbsp;&nbsp;   * cannot be empty</h4>
			
			<form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post" >
				<div class="input-field">
					<input type="text" name="email" value="<?php echo $email; ?>" size="30" required/>
					<label>Email Address*</label>
				</div>
				<div class="input-field">
					<input type="text" name="first" value="<?php echo $first; ?>" size="30" required/>
					<label>First Name*</label>
				</div>
				<div class="input-field">
				<input type="text" name="last" value="<?php echo $last; ?>" size="30" required />
					<label>Last Name*</label>
				</div>
				<div class="otherForm">
					<?php
					$table = 'salutation';
					echo build_simple_dropdown($table, $salutation);
					?>
					<label>Salutation</label>
				</div>
				<div class="input-field">
					<input type="text" name="street" value="<?php echo $street; ?>" size="30"  /> 
					<label>Street Address 1</label>
				</div>
				<div class="input-field">
					<input type="text" name="2ndStreet" value="<?php echo $secondStreet; ?>" size="30" /> 
					<label>Street Address 2</label>
				</div>
				<div class="input-field">
					<input type="text" name="city" value="<?php echo $city; ?>" size="30" />  
					<label>City</label>
				</div>
				<div class="otherForm">
					<?php 
						$table = 'provinces';
						echo build_simple_dropdown($table, $provinces);
					?> 
					<label>Province:</label>
				</div>
				<div class="input-field">
					<input type="text" name="postal" value="<?php echo $postal; ?>" size="30" /> 
					<label>Postal Code</label>
				</div>
				<div class="input-field">
					<input type="text" name="phone" value="<?php echo $phone; ?>" size="30" required/>
					<label>Phone Number*</label>
				</div>
				<div class="input-field">
					<input type="text" name="2ndPhone" value="<?php echo $secondPhone; ?>" size="30" />
					<label>Phone Number 2</label>
				</div>
				<div class="input-field">
					<input type="text" name="fax" value="<?php echo $fax; ?>" size="30" />
					<label>Fax Number</label>
				</div>
				<div class="radioForm">
					<div>
					Preferred contact method:
					</div>
						<?php
						$table = 'contact_method';
						echo build_radio($table,$selected_method)
						?>
				</div>
				<input type="submit" name="submit" value="Edit Profile" />
			</form>
		</div>
</section>
		
		
		
<?php include 'footer.php'; ?>
