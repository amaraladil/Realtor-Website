--Group 13
--finished_basement.sql
--October 19, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS finished_basement;

--Creates the table again
CREATE TABLE finished_basement(
	value INT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);


--Inserts rows inside the table
INSERT INTO finished_basement (value, property) VALUES (1, 'Yes'); 
INSERT INTO finished_basement (value, property) VALUES (2, 'No');
