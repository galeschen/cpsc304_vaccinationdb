CREATE TABLE Minor(
    PersonalHealthNumber	int,
    PRIMARY KEY (personalHealthNumber),
    FOREIGN KEY (personalHealthNumber) REFERENCES Patient(PersonalHealthNumber)
		ON DELETE CASCADE
);
