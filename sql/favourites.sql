--Group 13
--favourite.sql
--December 1, 2016
--WEBD3201


-- Dropping tables clear out any existing data
DROP TABLE IF EXISTS favourites;

--Creates the table again
CREATE TABLE favourites(
	user_id VARCHAR(20) REFERENCES users(user_id) NOT NULL,
	listing_id  INTEGER REFERENCES listings(listing_id) NOT NULL
);

/* 
    user_id: a varchar that can hold 20 characters (Make this so it cannot be NULL, and should have a corresponding record in the users table. i.e. make user_id in favourites a FOREIGN KEY). 
	This is the user that wants to track the specific listing, and they have to already exist as a user in the system.
    listing_id: an INTEGER (Make this so it cannot be NULL, and should have a corresponding record in the listings table. i.e. make listing_id in favourites a FOREIGN KEY). 
	This is the listing that the users wants to track, and the listing has to exist as a user in the system.


*/