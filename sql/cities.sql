--Group 13
--cities.sql
--October 19, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS cities;

--Creates the table again
CREATE TABLE cities(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);


--Inserts rows inside the table
INSERT INTO cities (value, property) VALUES (1, 'Ajax'); 
INSERT INTO cities (value, property) VALUES (2, 'Brooklin');
INSERT INTO cities (value, property) VALUES (4, 'Bowmanville');
INSERT INTO cities (value, property) VALUES (8, 'Oshawa');
INSERT INTO cities (value, property) VALUES (16, 'Pickering');
INSERT INTO cities (value, property) VALUES (32, 'Port Perry');
INSERT INTO cities (value, property) VALUES (64, 'Whitby');