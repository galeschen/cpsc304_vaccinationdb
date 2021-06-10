CREATE TABLE Clinic(
    ClinicID        CHAR(5),
    ManagerID       CHAR(5)         NOT NULL,
    StreetAddress   VARCHAR(30)     NOT NULL,
    PostalCode     CHAR(6)          NOT NULL    DEFAULT ‘XXXXXX’,
    ClinicName    VARCHAR(30)       NOT NULL,
    UNIQUE (StreetAddress, ClinicName),
    PRIMARY KEY (ClinicID),
    FOREIGN KEY (PostalCode) REFERENCES ClinicAddress
        ON DELETE SET DEFAULT
        ON UPDATE CASCADE,
    FOREIGN KEY (ManagerID) REFERENCES Manager(ID)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
);
