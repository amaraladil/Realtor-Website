-- File: contact_method.sql
-- Author: GROUP13
-- Date: October 19, 2016
-- Description: SQL file to create listing status property/value table

DROP TABLE IF EXISTS contact_method;

CREATE TABLE contact_method(
value CHAR(1) PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

INSERT INTO contact_method(value, property) VALUES ('E', 'Email');

INSERT INTO contact_method(value, property) VALUES ('P', 'Phone');

INSERT INTO contact_method(value, property) VALUES ('T', 'Text');
