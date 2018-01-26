--Group 13
--purchase_type.sql
--October 19, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS purchase_type;

--Creates the table again
CREATE TABLE purchase_type(
	value INT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);


--Inserts rows inside the table
INSERT INTO purchase_type (value, property) VALUES (1, 'For Sale'); 
INSERT INTO purchase_type (value, property) VALUES (2, 'For Rent');
