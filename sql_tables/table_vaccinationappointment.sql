CREATE TABLE VaccinationAppointment( 
    AppointmentID 	CHAR(5),
    ClinicID 		CHAR(5),
    Time		TIMESTAMP	NOT NULL,
    BookerPHN		int		NOT NULL,
    PatientPHN		int 		NOT NULL,
    NurseID		CHAR(5)	NOT NULL,
    VaccineID		CHAR(5)	NOT NULL,
    PRIMARY KEY(AppointmentID, ClinicID),
    FOREIGN KEY(ClinicID) REFERENCES Clinic(ClinicID),
    FOREIGN KEY(BookerPHN) REFERENCES Adult(personalHealthNumber)
        ON DELETE CASCADE,
    FOREIGN KEY(PatientPHN) REFERENCES Patient(PersonalHealthNumber)
        ON DELETE CASCADE
);
