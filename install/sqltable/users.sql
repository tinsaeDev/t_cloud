create table users(
	USERNAME varchar(50),
	PASSWORD varchar(50),
	ADMIN boolean DEFAULT false,
	FISRT_NAME varchar(50),
	FATHER_NAME varchar(50),
	GRAND_FATHER_NAME varchar(50),
	PRIMARY KEY(USERNAME)
)
