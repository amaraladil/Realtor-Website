--Group 13
--users.sql
--September 29, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS users;

--Creates the table again
CREATE TABLE users(
	user_id VARCHAR(20) PRIMARY KEY NOT NULL,
	password  VARCHAR(32) NOT NULL,
	user_type CHAR(1) NOT NULL,
	email_address VARCHAR(255) NOT NULL,
	enrol_date DATE NOT NULL,
	last_access DATE NOT NULL
);


--Inserts rows inside the table
INSERT INTO users VALUES('realtor','179ad45c6ce2cb97cf1029e212046e81','R','jdoe@durhamcollege.ca','2016-1-1','2016-2-1'); -- testpass
INSERT INTO users VALUES('aladila','36341cbb9c5a51ba81e855523de49dfd','R','amar.aladil@dcmail.ca','2016-3-13','2016-3-22'); --amar
INSERT INTO users VALUES('abc','202cb962ac59075b964b07152d234b70','R','jenny@gb.ca','2016-3-22','2016-3-4'); -- 123
INSERT INTO users VALUES('Mandy','1c625cc86f824660a320d185916e3c55','R','mandy@steria.ca','2016-4-20','2016-3-4'); --russia
