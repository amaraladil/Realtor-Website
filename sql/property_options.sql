--Group 13
--property_options.sql
--October 19, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS property_options;

--Creates the table again
CREATE TABLE property_options(
	value INT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);


--Inserts rows inside the table
INSERT INTO property_options (value, property) VALUES (1, 'AC'); 
INSERT INTO property_options (value, property) VALUES (2, 'Pool');
INSERT INTO property_options (value, property) VALUES (4, 'Fireplace');