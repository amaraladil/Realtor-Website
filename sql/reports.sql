--Group 13
--reports.sql
--December 1, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS reports;

--Creates the table again
CREATE TABLE reports(
	user_id VARCHAR(20) REFERENCES users(user_id) NOT NULL,
	listing_id  INTEGER REFERENCES listings(listing_id) NOT NULL,
	reported_on DATE NOT NULL,
	status CHAR(1) NOT NULL, 
	primary key (user_id, listing_id)
);

/*
    user_id: a varchar that can hold 20 characters (Make this so it cannot be NULL, and should have a corresponding record in the users table. i.e. make user_id in favourites a FOREIGN KEY). 
	This is the user that wants to track the specific listing, and they have to already exist as a user in the system.
    listing_id: an INTEGER (Make this so it cannot be NULL, and should have a corresponding record in the listings table. i.e. make listing_id in favourites a FOREIGN KEY). 
	This is the listing that the users wants to track, and the listing has to exist as a user in the system.
    reported_on: an DATE(Make this so it cannot be NULL) this should be the timestamp of when the listing was reported.
    status: an CHAR(1)(Make this so it cannot be NULL) this should be the the status of the incident (OPEN or CLOSED).
    For this table make the primary key a combination of the user_id and listing_id (i.e. a specific user can only have a specific listing id stored once in the db table).. E.g.
    PRIMARY KEY (user_id, listing_id)

*/