<?php
/*
Group_13 
September 29, 2016
WEBD3201
Login page
*/
$title = "Login";
$date = "September 29, 2016";
$filename = "login.php";
$description = "The login page ";
include("header.php");
?>
<?php
//Redirects if logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	header("Location: /");
}

//empty out error and result regardless of method that got you here
$error = "";
$output = (isset($_SESSION['message']))? $_SESSION['message']: "";
if (isset($_SESSION['message']) )
{
	unset($_SESSION['message']);
}
if($_SERVER["REQUEST_METHOD"] == "GET")
{
	//default mode when the page loads the first time
	//can be used to make decisions and initialize variables
	$id = "";
	$pass = "";
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	//the page got here from submitting the form, let's try to process
	$id = trim($_POST["id"]); //the name of the input box on the form, white-space removed
	$pass = trim($_POST["pass"]); //the name of the input box on the form, white-space removed
	
	//Converts the password into a hash
	$hashedPass = hash("md5", $pass);
	
	$result = pg_execute(db_connect(),"Log_In_query",array($id,$hashedPass));
	$records = pg_num_rows($result);
	//-------------------------------------------------------------------------------------------PASSES
	//Checks if both id and pass is correct
	if ($records == 1)
	{		
		pg_execute(db_connect(),"UpdateUserDate",array($id));
		//Sets users cookie
		$cookie_name = "user";
		$cookie_value = $id;
		setcookie("user",$cookie_value, time() + COOKIE_LENGTH, "/"); // 86400 = 1 day
		//Redirects to welcome page
		$_SESSION['loggedin'] = true;
		//-----------------------------------------------------------USERS TABLE SESSION VARIABLES
		$_SESSION['username'] = $id;
		$_SESSION['password'] = $pass;
		$_SESSION['user_type'] = pg_fetch_result($result, 0, "user_type");
		$_SESSION['email'] = pg_fetch_result($result, 0, "email_address");
		$_SESSION['enrol'] = pg_fetch_result($result, 0, "enrol_date");
		$_SESSION['last_access'] = pg_fetch_result($result, 0, "last_access");
		
		//-----------------------------------------------------------PEOPLE TABLE SESSION VARIABLES
		
		$result = pg_execute(db_connect(), "Get_Personal",array($id));
		$_SESSION['salutation'] = pg_fetch_result($result, 0, "salutation");
		$_SESSION['first_name'] = pg_fetch_result($result, 0, "first_name");
		$_SESSION['last_name'] = pg_fetch_result($result, 0, "last_name");
		$_SESSION['street_address_1'] = pg_fetch_result($result, 0, "street_address_1");
		$_SESSION['street_address_2'] = pg_fetch_result($result, 0, "street_address_2");
		$_SESSION['city'] = pg_fetch_result($result, 0, "city");
		$_SESSION['province'] = pg_fetch_result($result, 0, "province");
		$_SESSION['postal_code'] = pg_fetch_result($result, 0, "postal_code");
		
		$_SESSION['primary_phone'] = pg_fetch_result($result, 0, "primary_phone_number");
		$_SESSION['secondary_phone'] = pg_fetch_result($result, 0, "secondary_phone_number");
		$_SESSION['fax'] = pg_fetch_result($result, 0, "fax_number");
		$_SESSION['contact_method'] = pg_fetch_result($result, 0, "preferred_contact_method");
		
		//------------------------------------------------------------------------------------------------------------------------------------AGENT
		if ($_SESSION['user_type'] == GET_AGENT)
		{
			header("refresh:5;url=dashboard.php");
			$output =  "<br/>Successful logged-in as ".$id.", you will be redirected to your Dashboard page";
			ob_flush();
		}
		//------------------------------------------------------------------------------------------------------------------------------------USER
		else if($_SESSION['user_type'] == GET_USER)
		{
			header("refresh:5;url=welcome.php");
			$output =  "<br/>Successful logged-in as ".$id.", you will be redirected to your welcome page";
			ob_flush();
		}
		//------------------------------------------------------------------------------------------------------------------------------------ADMIN
		else if($_SESSION['user_type'] == GET_ADMIN)
		{
			header("refresh:5;url=admin.php");
			$output =  "<br/>Successful logged-in as ".$id.", you will be redirected to your admin page";
			ob_flush();
		}
		//------------------------------------------------------------------------------------------------------------------------------------PENDING AGENT
		else if($_SESSION['user_type'] == GET_PENDING)
		{
			$output =  "<br/>Successful logged-in as ".$id.", your account is still pending to be approved";
			session_destroy();
		}
		//------------------------------------------------------------------------------------------------------------------------------------DISABLED
		else if($_SESSION['user_type'] == GET_DISABLED)
		{
			$output =  "<br/>Successful logged-in as ".$id.", your account has been suspended".
			 			"<br/>You will be redirected to our Acceptable User Policy page";
			session_destroy();
			header("refresh:5;url=aup.php");
		}
	
	}
	else //-------------------------------------------------------------------------------USER AND PASSWORD NOT FOUND
	{
		if (is_user_id($id) == true)
		{
			//If user name is found at least
			$error = "Incorrect Password";
			$pass = "";
		}
		else
		{
			$error = "Login/password not found in the database";
			$id = "";
			$pass = "";
		}
	}
	
}
?>
<!-- about section start -->
<section class="content-body" id='formSetup'>
        <div class="max-width body-place">			
			<h2 class="title">Login Page</h2>
			<p>If your a realtor and don't have an account, please go to the <a href="./register.php">registration</a> page on the top bar.
			<br/>
            <h2 style="text-align: center;"><?php echo $output; ?></h2>
			<h3 style="text-align: center;"><?php echo $error; ?></h3>
			<form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post" >
				<p style="text-align: center;">Enter your login ID and password to connect to this system</p>
				<br/>
				<div class="input-field">
					<input type="text" name="id" value="<?php echo $id; ?>" size="30" required/>
					<label>Username</label>
				</div>
				<div class="input-field">
					<input type="password" name="pass" value="<?php echo $pass; ?>" size="30" required/> 
					<label>Password</label>
				</div>
				<input type="submit" value="Log In" /></td>
			</form>
        </div>
</section>
			
		
		
<?php include 'footer.php'; ?>
