--Group 13
--bedrooms.sql
--October 19, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS bedrooms;

--Creates the table again
CREATE TABLE bedrooms(
	value INT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);


--Inserts rows inside the table
INSERT INTO bedrooms (value, property) VALUES (1, '1'); 
INSERT INTO bedrooms (value, property) VALUES (2, '2');
INSERT INTO bedrooms (value, property) VALUES (4, '3');
INSERT INTO bedrooms (value, property) VALUES (8, '4');
INSERT INTO bedrooms (value, property) VALUES (16, '5 or more');