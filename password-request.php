<?php
/*
Group_13
November 22, 2016
WEBD3201
Password Request page
*/
$title = "Password Request";
$date = "November 22, 2016";
$filename = "password-request.php";
$description = "The password request page ";
include("header.php");
?>


<?php
//empty out error and result regardless of method that got you here
$error = "";
$output = "";

//Redirects anyone that trys to backdoor
if ( isset($_SESSION['loggedin']) )
{
	//------------------------------------------------------------------------------------------------------------------------------------AGENT
	if ($_SESSION['user_type'] == GET_AGENT)
	{
		header("Location: dashboard.php");
	}
	//------------------------------------------------------------------------------------------------------------------------------------USER
	else if($_SESSION['user_type'] == GET_USER)
	{
		header("Location: welcome.php");
	}
	//------------------------------------------------------------------------------------------------------------------------------------ADMIN
	else if($_SESSION['user_type'] == GET_ADMIN)
	{
		header("Location: admin.php");
	}
}


if($_SERVER["REQUEST_METHOD"] == "GET")
{
	//default mode when the page loads the first time
	//can be used to make decisions and initialize variables
	$id = "";
	$email = "";
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	//the page got here from submitting the form, let's try to process
	$id = trim($_POST["id"]); //the name of the input box on the form, white-space removed
	$email = trim($_POST["email"]); //the name of the input box on the form, white-space removed
	$headers = 'From: no-reply@HousesConnected.ca';
	$subject = "Password Changed";
	
	if ($id == "")
	{
		$error .= "<br/>User ID cannot be empty";
	}
	if ($email == "")
	{
		$error .= "<br/>Email cannot be empty";
	}
	
	if ($error == "")
	{	
		$sql = "SELECT * FROM users WHERE user_id = '$id'";
		$result = pg_query(db_connect(),$sql);
		$records = pg_num_rows($result);
		
		if ($records == 1)
		{	
					
			if ($email == pg_fetch_result($result, 0, "email_address") )
			{
				$output = "Email match";
				$sql = "SELECT * FROM people WHERE user_id = '$id'";
				$people = pg_query(db_connect(),$sql);
				
				$firstName = pg_fetch_result($people, 0, "first_name");
				$lastName = pg_fetch_result($people, 0, "last_name");
				$salutation = pg_fetch_result($people, 0, "salutation");
				$newPassword = randomPasswordGenerator();

				// the message
				$msg = "<img src=\"images/LogoFinal2.png\" width=\"200px\" /><br/>Hello $salutation $firstName $lastName,<br/> Your account for ".WEBSITE_NAME." has recently requested a new password, please use this new password <b> $newPassword </b> to login in. <br/>If you didn't request for an password change, don't worry! Please contact us right away to secure your account <br/><br/>Sincerely, <br/>".WEBSITE_NAME." <br/><br/>Request made: ".date("Y-m-d h:i:sa",time());
				
				// use wordwrap() if lines are longer than 70 characters
				$msg = wordwrap($msg,70);
				
				//echo $msg;
				
				// send email
				//mail($email,$subject,$msg,$headers);
				//Hashs password
				$hashedPassword = hash("md5", $newPassword);
				//Execute new password to database
				pg_execute(db_connect(),"update_password_request",array($hashedPassword,$id,$email,));
				//Creates message for user
				$_SESSION['message'] = "Email has been sent to $email, check for the new password there.";
				//Relocates to login page
				//header("Location: login.php");
			}
			else
			{
				$error .= "Email does not match the account";
			}
		}
		else
		{
			$error .= "User ID does not exist";
		}
	}
}
?> 


<h1>Password Request</h1>
		<hr/>
		<p>If you know your password and want to login, please go to the <a href="./login.php">login</a> page on the top bar.
		<br/>
		</p>
		<h2 style="text-align: center;"><?php echo $output; ?></h2>
		<h3 style="text-align: center;"><?php echo $error; ?></h3> 
		<p style="text-align: center;">Enter your login ID and email to request a password</p>
		<form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post" >
		<table style="border: none;
				background-color: #e5f2ff;
				width: auto;
				text-align: center;
				margin-left: auto;
				margin-right: auto;" cellspacing="15">
			<tr>
				<td>
					Login ID: 
				</td>
				<td><input type="text" name="id" value="<?php echo $id; ?>" size="30" /> <br/>
				</td>
			</tr>
			<tr>
				<td>Email: 
				</td>
				<td><input type="text" name="email" value="<?php echo $email; ?>" size="30" /> <br/>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Request Password" /></td>
			</tr>
		</table>
		</form>
		<br/>
	

<?php include 'footer.php'; ?>