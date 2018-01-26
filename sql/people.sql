--Group 13
--people.sql
--October 11, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS people;

--Creates the table again
/*
salutation: an VARCHAR that can hold up to 10 characters (can be empty)
first_name: a VARCHAR that can hold up to 25 characters (cannot be empty)
last_name: a VARCHAR that can hold up to 50 characters (cannot be empty)
street_address_1: a VARCHAR that can hold up to 75 characters (can be empty)
street_address_2: a VARCHAR that can hold up to 75 characters (can be empty)
city: a VARCHAR that can hold up to 75 characters (can be empty)
province: a VARCHAR that can hold up to 2 characters (can be empty)
postal_code: a VARCHAR that can hold up to 6 characters (can be empty)
primary_phone_number: a VARCHAR that can hold up to 15 characters (cannot be empty)
secondary_phone_number: a VARCHAR that can hold up to 10 characters (can be empty)
fax_number: a VARCHAR that can hold up to 10 characters (can be empty)
preferred_contact_method: a CHAR that can hold up to 1 character (cannot be empty)
*/
CREATE TABLE people(
	user_id VARCHAR(20) REFERENCES users(user_id) NOT NULL,
	salutation  VARCHAR(10),
	first_name VARCHAR(25) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	street_address_1 VARCHAR(75),
	street_address_2 VARCHAR(75),
	city VARCHAR(75),
	province VARCHAR(2),
	postal_code VARCHAR(6),
	primary_phone_number VARCHAR(15) NOT NULL,
	secondary_phone_number VARCHAR(10),
	fax_number  VARCHAR(10),
	preferred_contact_method CHAR(1) NOT NULL
);

/*
--Inserts rows inside the table
INSERT INTO people VALUES('realtor','179ad45c6ce2cb97cf1029e212046e81','R','jdoe@durhamcollege.ca','2016-1-1','2016-2-1'); -- testpass
INSERT INTO people VALUES('aladila','36341cbb9c5a51ba81e855523de49dfd','R','amar.aladil@dcmail.ca','2016-3-13','2016-3-22'); --amar
INSERT INTO people VALUES('abc','202cb962ac59075b964b07152d234b70','R','jenny@gb.ca','2016-3-22','2016-3-4'); -- 123
INSERT INTO people VALUES('Mandy','1c625cc86f824660a320d185916e3c55','R','mandy@steria.ca','2016-4-20','2016-3-4'); --russia
*/
