create table files(
	ID varchar(10),
	OWNER varchar(50),
	ABS_PATH varchar(500),
	PARENT_PATH varchar(10),
	ACTUAL_NAME varchar(500),
	FILE_TYPE varchar(50),
	FILE_SIZE int,
	SHARED boolean,
	SHAREd_LINK varchar(200),
	date_created date,
	deleted boolean,
	isDir boolean,

	PRIMARY KEY(ID),
	UNIQUE  KEY(ABS_PATH),
	FOREIGN KEY(OWNER) REFERENCES users(USERNAME) on delete cascade,
	FOREIGN KEY(PARENT_PATH) REFERENCES files(ID) on delete cascade
);