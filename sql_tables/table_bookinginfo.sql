CREATE TABLE BookingInfo(
    AppointmentID	CHAR(5),
    ClinicID		CHAR(5),
    BookerPHN		int		NOT NULL,
    PRIMARY KEY (AppointmentID, ClinicID),
    FOREIGN KEY (AppointmentID,ClinicID) REFERENCES VaccinationAppointment,
    FOREIGN KEY (BookerPHN) REFERENCES Patient(PersonalHealthNumber)
);
