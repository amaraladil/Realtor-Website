<?php
/*
Group 13
November 10, 2016
WEBD3201
User Password Change Page
*/
$title = "Change Password";
$date = "November 2, 2016";
$filename = "user-password.php";
$description = " A page that allows the logined in user to change their current password";
include("header.php");
?>
<?php

$output = "";
$error = "";
$curpassword = "";
$newpassword = "";
$confpassword = "";
// Set id to the username from the session
$id = (isset($_SESSION['username']) )? $_SESSION['username']: "";
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		// Defaults when the page loads
		$curpassword = "";
		$newpassword = "";
		$confpassword = "";
	}
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// Deafults for the values when the user has submitted new password
		$curpassword = trim($_POST["curpassword"]); // The user's current password
		$newpassword = trim($_POST["newpassword"]); // The new password the user has entered
		$confpassword = trim($_POST["confpassword"]); // Conmfirmation of the new password
		$error = "";

		// ##Current Password##
		// Checks if the user has entered anything for their current password, and if so if it's between the MAX and MIX PASSWORD_LENGTH
		if(trim(strlen($curpassword)) == 0 || $curpassword == "")
		{
			// Generates an error when the user hasn't entered their password
			$error .= "Must enter the account's current password <br/>";
			$curpassword = "";
			$newpassword = "";
			$confpassword = "";
		}
		// Checks if the user has entered the correct password for the account
		else if(!($curpassword == $_SESSION['password']) )
		{
			// Generates an error when the user hasn't entered the right password
			$error .= "You must enter the correct current password <br/>";
			$curpassword = "";
			$newpassword = "";
			$confpassword = "";
		}
		// ##New Password##
		// Checks if the user has entered anything for the new password, and if so if it's between the MAX and MIX PASSWORD_LENGTH
		if(trim(strlen($newpassword)) == 0 || $newpassword == "")
		{
			// Generates an error when the user hasn't entered their password
			$error .= "Must enter a new password. <br/>";
			$curpassword = "";
			$newpassword = "";
			$confpassword = "";
		}
		// Checks if the new password is between the min and max lengths
		else if(trim(strlen($newpassword)) < MINIMUM_PASSWORD_LENGTH || strlen($newpassword) > MAXIMUM_PASSWORD_LENGTH)
		{
			// Generates an error if the user's current password is in between the MAX and MIN lengths
			$error .= "Your new password must be between ".MINIMUM_PASSWORD_LENGTH." and ".MAXIMUM_PASSWORD_LENGTH." <br/>";
			$curpassword = "";
			$newpassword = "";
			$confpassword = "";
		}
		
		// ##Confirm New Password##
		// Checks if the new password matches the confirm password
		else if(($newpassword) != ($confpassword))
		{
			// Generates an error when the new & confirm password doesn't match
			$error .= "Your new password didn't match the confirm password. <br/>";
			$curpassword = "";
			$newpassword = "";
			$confpassword = "";
		}
			
		// ##Database Check/Update##
		// Current, new, and confirm passwords are valid from above, connect to the database and check/update
		// Checks if the session is avaliable
		if($error == "")
		{
			
			// Hashes the current password
			$hashedCurPass = hash("md5", $curpassword);
			// Hashes the new password
			$hashedNewPass = hash("md5", $newpassword);
			// Execute the prepared statement 
			pg_execute(db_connect(),"update_user_pass",array($hashedNewPass,$id,$hashedCurPass,));
			
			$_SESSION['password'] = $newpassword;
			
			//------------------------------------------------------------------------------------------------------------------------------------AGENT
			if ($_SESSION['user_type'] == GET_AGENT)
			{
				header("refresh:5;url=dashboard.php");
				$output =  "<br/>Successful changed your password, you will be redirected to the Dashboard page";
				ob_flush();
			}
			//------------------------------------------------------------------------------------------------------------------------------------USER
			else if($_SESSION['user_type'] == GET_USER)
			{
				header("refresh:5;url=welcome.php");
				$output =  "<br/>Successful changed your password, you will be redirected to the welcome page";
				ob_flush();
			}
			//------------------------------------------------------------------------------------------------------------------------------------ADMIN
			else if($_SESSION['user_type'] == GET_ADMIN)
			{
				header("refresh:5;url=admin.php");
				$output =  "<br/>Successful changed your password, you will be redirected to the admin page";
				ob_flush();
			}
			
		}
		
	}
}
else
{
	// If the session is not avaliable, display an error
	$error .= "You must be logged in to change password. <br/>";
	$error .= "You will be redirected to login page <br/>";
	header("Location: login.php");
}		

?>
<section class="content-body" id='formSetup'>
        <div class="max-width body-place">			
			<h2 class="title">Password Change</h2>
		<p>If you would like to change your current password, then contiune below.
		</p>
		<h2 style="text-align: center;">Enter your current password and a new password.</h2>
		<h3 style="text-align: center;"><?php echo $error; ?> </h3>
		<h3 style="text-align: center;"><?php echo $output; ?> </h3>
		<form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post" >
			<br/>
			<div class="input-field">
				<input type="text" name="username" value="<?php echo $id;?>" size="30" disabled />
				<label>Username</label>
			</div>
			<div class="input-field">
			<input type="password" name="curpassword" value="" size="30"/>
				<label>Current Password:</label>
			</div>
			<div class="input-field">
			<input type="password" name="newpassword" value="" size="30"/>
				<label>New Password:</label>
			</div>
			<div class="input-field">
			<input type="password" name="confpassword" value="" size="30"/>
				<label>Confirm Password:</label>
			</div>
			<input type="submit" value="Submit"/>
		</form>
	</div>
</section>
<?php include 'footer.php'; ?>