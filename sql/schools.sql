--Group 13
--schools.sql
--October 19, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS schools;

--Creates the table again
CREATE TABLE schools(
	value INT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);


--Inserts rows inside the table
INSERT INTO schools (value, property) VALUES (1, 'Yes'); 
INSERT INTO schools (value, property) VALUES (2, 'No');