<!--
	Programmer: Group_13
	Program Name: <?php echo $filename; ?> 
	Date: <?php echo $date; ?> 
	Purpose: <?php echo $description; ?> 
-->
<?php 	session_start();
		require("./includes/constants.php");
		require("./includes/functions.php");
		require("./includes/db.php");	
		
		ob_start();
		
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head>
	<link rel="shortcut icon" href="images/LogoFinal_Icon.ico" />
	<link rel="stylesheet" type="text/css" href="css/webd3201.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?>  </title>	
</head>
<body class="text-color">
<div id="container">
	<div id="header">
		<img src="images/LogoFinal2.png" alt="Web Logo" width="500" height="128"/>
			<h1><?php echo WEBSITE_NAME; ?></h1>
	</div>
	<div id="sites">
		<ul>
			<li><a href="./index.php">Home Page</a></li>
			<?php
			//Shows only when the user is not logged-in
			if (!isset($_SESSION['loggedin']))
			{
				echo "<li><a href=\"./login.php\">Login</a></li>";
				echo "<li><a href=\"./register.php\">Register</a></li>";
				echo "<li><a href=\"./password-request.php\">Password Request</a></li>";
			}
			?>
			
			<?php
			//Shows only for CLIENTS
			if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] == GET_USER) 
			{
				echo "<li><a href=\"./welcome.php\">Welcome</a></li>";
			}
			//Shows only for AGENTS
			else if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] == GET_AGENT) 
			{
				echo "<li><a href=\"./dashboard.php\">Dashboard</a></li>";
				echo "<li><a href=\"./listing-create.php\">List Create</a></li>";
			}
			//Shows only for ADMIN
			else if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] == GET_ADMIN) 
			{
				echo "<li><a href=\"./admin.php\">Admin</a></li>";
				echo "<li><a href=\"./disabled-users.php\">Disabled Users</a></li>";
			}

			?>
			<!--<li><a href="./listing-create.php">List Create</a></li>-->
			<li><a href="./listing-cities.php">Search</a></li>
			
			<?php
			//Shows for logged in users
			if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) 
			{
				echo "<li><a href=\"./user-update.php\">Edit Profile</a></li>";
				echo "<li><a href=\"./user-password.php\">Change Password</a></li>";
				echo "<li><a href=\"./logout.php\">Log Out</a></li>";
			}
			?>
		</ul> 
	</div>
	<div id="content-container">
