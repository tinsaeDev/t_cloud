create table trash(
	ID varchar(10),
	DATE_DELETED date,

	FOREIGN KEY(ID) REFERENCES files(ID)  on delete cascade
);
