CREATE TABLE VaccinePatient (
	VaccineID			CHAR(5),
	PatientPHN			int,
	RemainingDoses		INT		NOT NULL,
	ImmunityExpirationDate	DATE,
	PRIMARY KEY (VaccineID, PatientPHN),
	FOREIGN KEY (VaccineID) REFERENCES Vaccine(ID)
		ON DELETE CASCADE,
	FOREIGN KEY (PatientPHN) REFERENCES Patient(PersonalHealthNumber)
		ON DELETE CASCADE,
);
