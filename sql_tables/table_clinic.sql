CREATE TABLE Clinic(
    ClinicID        CHAR(5),
    ManagerID       CHAR(5),
    StreetAddress   VARCHAR(30)     NOT NULL,
    PostalCode      CHAR(6),
    City            VARCHAR(30),
    ClinicName      VARCHAR(30)     NOT NULL,
    UNIQUE      (StreetAddress, ClinicName),
    PRIMARY KEY (ClinicID),
    FOREIGN KEY (PostalCode,City) REFERENCES ClinicAddress,
    FOREIGN KEY (ManagerID) REFERENCES Manager(ID)
        ON DELETE CASCADE
);