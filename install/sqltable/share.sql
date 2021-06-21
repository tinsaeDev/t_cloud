create table share(

	ID varchar(10),
	SHARED_WITH varchar(50),
	DATE_SHARED date,

	FOREIGN KEY(ID) REFERENCES files(ID)  on delete cascade,
	FOREIGN KEY(SHARED_WITH) REFERENCES users(USERNAME)  on delete cascade,
	UNIQUE KEY (ID,SHARED_WITH)
);