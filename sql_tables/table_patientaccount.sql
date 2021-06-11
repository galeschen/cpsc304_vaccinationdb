CREATE TABLE PatientAccount(
	Username			VARCHAR(20),
	ppassword			VARCHAR(30)		NOT NULL,
	PersonalHealthNumber	int			NOT NULL,
	UNIQUE (PersonalHealthNumber),
	PRIMARY KEY (Username),
	FOREIGN KEY (PersonalHealthNumber) REFERENCES Patient
    ON DELETE CASCADE
);


