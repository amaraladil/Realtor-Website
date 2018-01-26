--Group 13
--washrooms.sql
--October 19, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS washrooms;

--Creates the table again
CREATE TABLE washrooms(
	value INT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);


--Inserts rows inside the table
INSERT INTO washrooms (value, property) VALUES (1, '1'); 
INSERT INTO washrooms (value, property) VALUES (2, '2');
INSERT INTO washrooms (value, property) VALUES (4, '3');
INSERT INTO washrooms (value, property) VALUES (8, '4');
INSERT INTO washrooms (value, property) VALUES (16, '5 or more');