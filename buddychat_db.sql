
/*
	Table: Users
	Desc : contains the user details of all who visit the website
	
	Structure:
		id - stores an unique id for each visitor
		pairid - stores if any pair is available for the users
		dt - stores the last update of user(check to see if alive)
		gender - enum M or F (future use)
		isconnected - boolean indiacting if the user is connected.

*/

create table users(
	
	id int(20) auto_increment primary key,
	pairid int(20) default null,
	dt datetime null,
	gender enum('M','F'),
	isconnected boolean default false
	
	);

/*
	Table: Pair
	Desc : Contains the current pair details..
	
	Structure:
		pairid - stores an unique pairid for each pair
		buddy1 - stores the id of one buddy
		buddy2 - stores the id of another buddy
		dt - stores the time of the buddy pair created

*/


create table pair(
	pairid int(20) auto_increment primary key,
	buddy1 int(20) default null,
	buddy2 int(20) default null,
	dt datetime
	);


/*
	Table: msg
	Desc : contains the messages one buddy sends to another
	
	Structure:
		pairid - stores the unique pairid of the pair in which the buddy is currently connected.
		buddyid - the buddyid who sents the message
		msg - message the buddy sent the other
		dt - stores the time of message sent by the sender buddy
		view - boolean to indicate if the message is viewed by the other buddy
		
		index pairid for faster search of message since this is real time..
		primary key's would be automatically index

*/


create table msg (
	msgid int(20) auto_increment primary key,
	pairid int(20) ,
	buddyid int(20),
	msg varchar(500),
	view boolean default false,
	dt datetime,
	index (pairid));

