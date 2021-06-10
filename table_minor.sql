CREATE TABLE Minor(
    PersonalHealthNumber	int,
    PRIMARY KEY (personalHealthNumber),
    FOREIGN KEY (personalHealthNumber) REFERENCES Patient(personalHealthNumber)
		ON DELETE CASCADE
);
