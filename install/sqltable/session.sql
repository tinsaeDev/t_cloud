create table session(
	value varchar(100),
	user varchar(50),
	date_created date,
	device varchar(50),

	FOREIGN KEY(user) REFERENCES users(USERNAME)  on delete cascade
);
