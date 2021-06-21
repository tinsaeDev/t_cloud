create table storage(
	user varchar(50),
	total int(20),
	used int(20),
	
	FOREIGN KEY(user) REFERENCES users(USERNAME) on delete cascade
)