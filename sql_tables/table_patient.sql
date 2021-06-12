CREATE TABLE Patient(
	PersonalHealthNumber 	int,
	PName			    VARCHAR(30)	    NOT NULL,
	PSex				CHAR(1)		    NOT NULL,
	StreetAddress		VARCHAR(30)	    NOT NULL,
	PostalCode			CHAR(6)		    NOT NULL,
	DateOfBirth			date			NOT NULL,
    PRIMARY KEY (PersonalHealthNumber),
	FOREIGN KEY (PostalCode) REFERENCES PatientAddress
);