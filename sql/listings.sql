--Group 13
--listings.sql
--October 19, 2016
--WEBD3201

drop sequence if exists listing_id_seq;
--autoincrement an identifier every time a record is inserted
create sequence listing_id_seq;
select setval('listing_id_seq', 10000);

--Creates the listings table
CREATE TABLE listings(
    listing_id INTEGER PRIMARY KEY DEFAULT NEXTVAL('listing_id_seq'), 
	user_id VARCHAR(20) NOT NULL REFERENCES users(user_id),
	status CHAR(1) NOT NULL,
	price NUMERIC NOT NULL,
	headline VARCHAR(100) NOT NULL,
	description VARCHAR(1000) NOT NULL,
	postal_code CHAR(6) NOT NULL,
	images SMALLINT DEFAULT(0) NOT NULL,
	city INTEGER NOT NULL,
	property_options INTEGER NOT NULL,
	bedrooms INTEGER NOT NULL,
	bathrooms INTEGER NOT NULL,
	garage INTEGER DEFAULT(0) NOT NULL,
	purchase_type INTEGER DEFAULT(0) NOT NULL,
	property_type INTEGER DEFAULT(0) NOT NULL,
	finished_basement INTEGER DEFAULT(0) NOT NULL,
	open_house INTEGER DEFAULT(0) NOT NULL,
	schools INTEGER DEFAULT(0) NOT NULL
);

--Inserts rows inside the table
INSERT INTO people VALUES('realtor','Ms.','Joe','Doe','Magic Land','','','','','1231231234','','','P'); -- testpass
INSERT INTO people VALUES('aladila','Mr.','Amar','Al-Adil','Westney Rd.','','Ajax','ON','L1T2N1','1231231234','','','T');  --amar
INSERT INTO people VALUES('abc','Ms.','Joe','Doe','Magic Land','','','','','1231231234','','','E');  -- 123
INSERT INTO people VALUES('Mandy','Ms.','Joe','Doe','Magic Land','','','','','1231231234','','','P');  --russia