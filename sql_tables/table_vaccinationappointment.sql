CREATE TABLE VaccinationAppointment( 
    AppointmentID 	CHAR(5),
    ClinicID 		CHAR(5),
    Time		TIMESTAMP	NOT NULL,
    BookerPHN		int		NOT NULL,
    PatientPHN		int 	NOT NULL,
    NurseID		    CHAR(5)	NOT NULL,
    VaccineID		CHAR(5)	NOT NULL,
    PRIMARY KEY(AppointmentID, ClinicID),
    FOREIGN KEY(ClinicID) REFERENCES Clinic(ClinicID),
    FOREIGN KEY(BookerPHN) REFERENCES Adult(PersonalHealthNumber)
        ON DELETE CASCADE,
    FOREIGN KEY(VaccineID,PatientPHN) REFERENCES VaccinePatient
        ON DELETE CASCADE,
    FOREIGN KEY(NurseID) REFERENCES Nurse(ID)
        ON DELETE CASCADE
);
