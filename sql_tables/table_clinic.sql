CREATE TABLE Clinic(
    ClinicID        CHAR(5),
    ManagerID       CHAR(5),
    StreetAddress   VARCHAR(30)     NOT NULL,
    PostalCode      CHAR(6),
<<<<<<< Updated upstream
    City            VARCHAR(30),
    ClinicName      VARCHAR(30)     NOT NULL,
    UNIQUE      (StreetAddress, ClinicName),
    PRIMARY KEY (ClinicID),
    FOREIGN KEY (PostalCode,City) REFERENCES ClinicAddress,
=======
    ClinicName      VARCHAR(30)     NOT NULL,
    UNIQUE      (StreetAddress, ClinicName),
    PRIMARY KEY (ClinicID),
    FOREIGN KEY (PostalCode) REFERENCES ClinicAddress,
>>>>>>> Stashed changes
    FOREIGN KEY (ManagerID) REFERENCES Manager(ID)
        ON DELETE CASCADE
);
