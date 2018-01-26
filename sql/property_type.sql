--Group 13
--property_type.sql
--October 19, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS property_type;

--Creates the table again
CREATE TABLE property_type(
	value INT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);


--Inserts rows inside the table
INSERT INTO property_type (value, property) VALUES (1, 'House'); 
INSERT INTO property_type (value, property) VALUES (2, 'Semi-Detached');
INSERT INTO property_type (value, property) VALUES (4, 'Condo');
INSERT INTO property_type (value, property) VALUES (8, 'Townhouse');