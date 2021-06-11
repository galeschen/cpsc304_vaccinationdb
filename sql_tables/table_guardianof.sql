
CREATE TABLE GuardianOf (
	GuardianPHN		int,
	DependentPHN	int,
	PRIMARY KEY (GuardianPHN, DependentPHN),
	FOREIGN KEY (GuardianPHN) REFERENCES Adult(PersonalHealthNumber),
	FOREIGN KEY (DependentPHN) REFERENCES Minor(PersonalHealthNumber)
		ON DELETE CASCADE
);