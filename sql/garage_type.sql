--Group 13
--garage_type.sql
--October 19, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS garage_type;

--Creates the table again
CREATE TABLE garage_type(
	value INT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);


--Inserts rows inside the table
INSERT INTO garage_type (value, property) VALUES (1, 'No Garage'); 
INSERT INTO garage_type (value, property) VALUES (2, 'One Garage'); 
INSERT INTO garage_type (value, property) VALUES (4, 'Double Garage');
INSERT INTO garage_type (value, property) VALUES (8, 'Three Garage or more');