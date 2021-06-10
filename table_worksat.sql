CREATE TABLE WorksAt(
    NurseID    CHAR(5),
    ClinicID    CHAR(5),
    PRIMARY KEY (NurseID, ClinicID),
    FOREIGN KEY (NurseID) REFERENCES Nurse(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (ClinicID) REFERENCES Clinic(ClinicID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
