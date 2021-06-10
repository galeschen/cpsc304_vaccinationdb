CREATE TABLE VaccinationAppointment( 
    AppointmentID 	CHAR(5),
    ClinicID 		CHAR(5),
    Time		DATETIME	NOT NULL,
    BookerPHN		int		DEFAULT	"0000000"	NOT NULL,
    PatientPHN		int 		NOT NULL,
    NurseID		CHAR(5)	NOT NULL,
    VaccineID		CHAR(5)	NOT NULL,
    PRIMARY KEY(AppointmentID, ClinicID),
    FOREIGN KEY(ClinicID) REFERENCES Clinic(ClinicID),
    FOREIGN KEY(BookerPHN) REFERENCES Adult(personalHealthNumber)
        ON DELETE SET DEFAULT,
    FOREIGN KEY(PatientPHN) REFERENCES VaccinePatient(PatientPHN)
        ON DELETE CASCADE,
);
