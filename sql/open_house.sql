--Group 13
--open_house.sql
--October 19, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS open_house;

--Creates the table again
CREATE TABLE open_house(
	value INT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);


--Inserts rows inside the table
INSERT INTO open_house (value, property) VALUES (1, 'Yes'); 
INSERT INTO open_house (value, property) VALUES (2, 'No');