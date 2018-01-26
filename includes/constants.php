<?php

/*
Group 13
September 29, 2016
--WEBD3201
*/

	//Dataconnect CONSTANTS
	define("HOST_DB", "127.0.0.1");
	define("NAME_DB", "group13_db");
	define("USER_DB", "group13_admin");
	define("PASSWORD_DB", "skype");

	//For registeration 
	define("MINIMUM_ID_LENGTH", 5);
	define("MAXIMUM_ID_LENGTH", 20);
	define("MINIMUM_PASSWORD_LENGTH", 6);
	define("MAXIMUM_PASSWORD_LENGTH", 32);
	define("MAX_FIRST_NAME_LENGTH", 25);
	define("MAX_LAST_NAME_LENGTH", 50);
	define("MAXIMUM_EMAIL_LENGTH", 255);
	define("MAXIMUM_POSTAL_LENGTH", 6);
	define("MAXIMUM_STREET_LENGTH", 75);
	define("MINIMUM_PHONE_LENGTH", 200);
	
	define("WEBSITE_NAME", "Houses Connected");
	
	//User_Type constants
	define("GET_ADMIN", "A");
	define("GET_AGENT", "R");
	define("GET_PENDING", "P");
	define("GET_DISABLED", "D");
	define("GET_USER", "U");
	define("GET_INCOMPLETE", "I");
	
	//Contact_Methods
	define("EMAIL", "E");
	define("PHONE", "P");
	define("MAIL", "M");
	define("TEXT", "T");
	
	//Listing Status
	define("OPEN", "O");
	define("CLOSED", "C");
	define("SOLD", "S");
	define("HIDDEN", "H");
	define("DISABLED", "D");
	
	//How many previews are shown on one page
	define("PAGE_LIMIT", 10);
	
	//Image Size Limit
	define("IMAGE_SIZE_LIMIT", 1000000);
	//Limit the amount of images can be saved in folder
	define("IMAGE_AMOUNT_LIMIT", 7);
	
	//This is used for the cookie length, 86400 is the total seconds within 24 hours and second number is the number of days
	define("COOKIE_LENGTH", (86400 * 30))
	
?>