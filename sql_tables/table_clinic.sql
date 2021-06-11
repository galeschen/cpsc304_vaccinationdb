CREATE TABLE Clinic(
    ClinicID        CHAR(5),
    ManagerID       CHAR(5),
    StreetAddress   VARCHAR(30)     NOT NULL,
    PostalCode      CHAR(6)         DEFAULT 'XXXXXX'	NOT NULL,
    ClinicName      VARCHAR(30)     NOT NULL,
    UNIQUE      (StreetAddress, ClinicName),
    PRIMARY KEY (ClinicID),
    FOREIGN KEY (PostalCode) REFERENCES ClinicAddress(PostalCode)
        ON DELETE SET NULL,
    FOREIGN KEY (ManagerID) REFERENCES Manager(ID)
        ON DELETE CASCADE
);
