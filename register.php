<?php
/*
Group_13
September 29, 2016
WEBD3201
Register page
*/
$title = "Register";
$date = "September 28, 2016";
$filename = "register.php";
$description = "The register page ";
include("header.php");
?>
<?php
/*
$sql = 'SELECT * FROM contact_method';
$_SESSION['radioSes'] = build_radio($sql);*/
//empty out error and result regardless of method that got you here
$error = "";
$output = "";
//$getContact = $_SESSION['radioSes'];

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	
	//default mode when the page loads the first time
	//can be used to make decisions and initialize variables
	//User Table Fields
	$id = "";
	$pass = "";
	$vPass = "";
	$first = "";
	$last = "";
	$email = "";
	//People Table Fields
	$salutation = "";
	$provinces = "";
	$contact = "";
	$street = "";
	$secondStreet = "";
	$city = "";
	$postal = "";
	$phone = "";
	$secondPhone = "";
	$fax = "";
	$selected_method = "";	
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	
	//the page got here from submitting the form, let's try to process
	$id = trim($_POST["id"]); //the name of the input box on the form, white-space removed
	$pass = trim($_POST["pass"]); //the name of the input box on the form, white-space removed
	$vPass = trim($_POST["vPass"]); //the name of the input box on the form, white-space removed
	$first = trim($_POST["first"]); //the name of the input box on the form, white-space removed
	$last = trim($_POST["last"]); //the name of the input box on the form, white-space removed
	$email = trim($_POST["email"]); //the name of the input box on the form, white-space removed	
	$user_type = GET_USER;
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
	
	//----------------------------------------------------------------------------------------------USER ID
	if(!isset($id) || $id == "")
	{
		//means the user did not enter anything
		$error .= "User ID is empty. <br/>";
	}
	else if (trim(strlen($id)) < MINIMUM_ID_LENGTH ||strlen($id) > MAXIMUM_ID_LENGTH)
	{
		$error .= "User ID must be between ".MINIMUM_ID_LENGTH." and ".MAXIMUM_ID_LENGTH." <br/>";
	}
	else if ( is_user_id($id) == true)
	{
			$error .= "User ID (".$id.") already taken <br/>";
			$id = "";
	}
	
	//----------------------------------------------------------------------------------------------PASSWORD
	if(!isset($pass) || $pass == "")
	{
		//means the user did not enter anything
		$error .= "Password is empty. <br/>";
	}
	else if (trim(strlen($pass)) < MINIMUM_PASSWORD_LENGTH ||strlen($pass) > MAXIMUM_PASSWORD_LENGTH)
	{
		$error .= "Password must be between ".MINIMUM_PASSWORD_LENGTH." and ".MAXIMUM_PASSWORD_LENGTH." <br/>";
		$pass = "";
		$vPass = "";
	}
	
	//----------------------------------------------------------------------------------------------CONFIRM PASSWORD
	if (!($pass == $vPass))
	{
		$error .= "Confirm Password does not match Password. <br/>";
		$pass = "";
		$vPass = "";
	}
	
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
	}/*
	else if  (!eregi("^[_a-z2-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$", $email)) 
	{
		$error .= "Email (".$email.") has inappropriate characters (\+\"\'~!([{\/?#$%^&*+=). <br/>";
		$email = "";
	}
	else if  (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))
	{
		$error .= "Email (".$email.") extension is wrong (.com, .ca, .us etc...) <br/>";
		$email = "";
	}*/
	
	//----------------------------------------------------------------------------------------------USER IS REALTOR OR NOT
	if (isset($_POST['realtor'])) 
	{
		$user_type = GET_PENDING;
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
	if( !isset($phone) || $phone == "")//Cannot be null or empty
	{
		$error .= "Phone number input is empty. <br/>";
	}
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
	if (isset($_POST['contact_method']))//Sets the variable
	{
		$selected_method = $_POST['contact_method'];
	}
	else
	{
		$error .= "\n Prefered Contact Method cannot be empty" . $_POST['contact_method'];
	}
	
	//if error is an empty string
	if($error == "")
	{  
		
		$output = "Successful Registered";
		
		pg_execute(db_connect(),"insert_user",array($id,hash("md5", $pass),$user_type,$email,date("Y-m-d",time()),date("Y-m-d",time()) ) );
		
		pg_execute(db_connect(),"insert_people",array($id,$salutation,$first,$last,$street,$secondStreet,$city,$provinces,$postal,$phone,$secondPhone,$fax,$selected_method) );

		header("refresh:5;url=login.php");
		ob_flush();
	}
	
	
}
?>
<!-- about section start -->
<section class="content-body" id='formSetup'>
        <div class="max-width body-place">			
			<h2 class="title">Registration Page</h2>
            <h2 style="text-align: center;"><?php echo $output; ?></h2>
			<h3 style="text-align: center;"><?php echo $error; ?></h3>
			<form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post" >
				<h3 style="text-align: center;">Fill in all Account Information </h3>
				<h4 style="text-align: center;">&nbsp;&nbsp;   * means they are required</h4>
				<div class="input-field">
					<input type="text" name="id" value="<?php echo $id; ?>" size="30" required/>
					<label>Username*</label>
				</div>
				<div class="input-field">
					<input type="password" name="pass" value="<?php echo $pass; ?>" size="30" required/> 
					<label>Password*</label>
				</div>
				<div class="input-field">
					<input type="password" name="vPass" value="" size="30" required/>
					<label>Confirm Password*</label>
				</div>
				<div class="input-field">
					<input type="text" name="email" value="<?php echo $email; ?>" size="30" required/>
					<label>Email Address*</label>
				</div>
				<div class="otherForm">
					<input type="checkbox" name="realtor" value="realtor"  <?php echo $out = (isset($_POST['realtor']) == true)? "checked": "";  ?> />
					<label>You a Realtor?</label>
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
				<input type="submit" value="Log In" /></td>
			</form>
        </div>
</section>
		
		
<?php include 'footer.php'; ?>
