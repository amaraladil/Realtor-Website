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
<!DOCTYPE html> 
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="images/LogoFinal_Icon.ico" />
	<!-- <link rel="stylesheet" type="text/css" href="css/webd3201.css"/> -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/script.js"></script>
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
    <title><?php echo $title; ?>  </title>	
</head>
<body>
    <div class="scroll-up-btn">
        <i class="fas fa-angle-up"></i>
    </div>
    <nav class="navbar">
        <div class="max-width">
            <div class="logo"><a href="/">Houses<span>Connected.</span></a></div>
            <ul class="menu">
                <?php
                //Shows only for CLIENTS
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] == GET_USER) 
                {
                    echo "<li><a href=\"./welcome.php\" class=\"menu-btn\">Welcome</a></li>";
                }
                //Shows only for AGENTS
                else if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] == GET_AGENT) 
                {
                    echo "<li><a href=\"./dashboard.php\" class=\"menu-btn\">Dashboard</a></li>";
                    echo "<li><a href=\"./listing-create.php\" class=\"menu-btn\">List Create</a></li>";
                }
                //Shows only for ADMIN
                else if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] == GET_ADMIN) 
                {
                    echo "<li><a href=\"./admin.php\" class=\"menu-btn\">Admin</a></li>";
                    echo "<li><a href=\"./disabled-users.php\" class=\"menu-btn\">Disabled Users</a></li>";
                }

                ?>
                <li><a href="listing-cities.php" class="menu-btn">Search</a></li>
                <?php
                //Shows only when the user is not logged-in
                if (!isset($_SESSION['loggedin']))
                {
                    echo "<li><a href=\"login.php\" class=\"menu-btn\">Login</a></li>
                    <li><a href=\"register.php\" class=\"menu-btn\">Register</a></li>";
                }
                ?>
            </ul>
            <div class="menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>
    