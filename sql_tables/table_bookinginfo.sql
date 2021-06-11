CREATE TABLE BookingInfo(
    AppointmentID	CHAR(5),
    ClinicID		CHAR(5),
    BookerPHN		int		NOT NULL,
    PRIMARY KEY(AppointmentID, ClinicID),
    FOREIGN KEY(AppointmentID) REFERENCES VaccinationAppointment(AppointmentID),
    FOREIGN KEY(ClinicID) REFERENCES Clinic(ClinicID),
    FOREIGN KEY(BookerPHN) REFERENCES Patient(personalHealthNumber)
);
