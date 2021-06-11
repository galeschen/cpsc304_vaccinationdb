CREATE TABLE IsLinkedTo(
	dependentUsername		VARCHAR(20),
	guardianUsername		VARCHAR(20),
	PRIMARY KEY (dependentUsername, guardianUsername),
    FOREIGN KEY (dependentUsername) REFERENCES PatientAccount(Username)
		ON DELETE CASCADE,
    FOREIGN KEY (guardianUsername) REFERENCES PatientAccount(Username)
);