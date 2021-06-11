
create table Adult(
		PersonalHealthNumber	int,
		PRIMARY KEY (PersonalHealthNumber),
		FOREIGN KEY (PersonalHealthNumber) 
		REFERENCES Patient(PersonalHealthNumber)
		ON DELETE CASCADE 
);