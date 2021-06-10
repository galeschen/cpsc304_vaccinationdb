CREATE TABLE AssistsBooking(
    AppointmentID	CHAR(5),
    ClinicID		CHAR(5),
    ClerkID		    CHAR(5)	    DEFAULT	‘N/A’,
    PRIMARY KEY (AppointmentID, ClinicID, ClerkID),
    FOREIGN KEY (AppointmentID) REFERENCES BookingInfo(AppointmentID)
        ON DELETE CASCADE,
    FOREIGN KEY (ClinicID) REFERENCES BookingInfo(ClinicID),
    FOREIGN KEY (ClerkID) REFERENCES ClericalStaff(ID)
        ON DELETE SET DEFAULT
);
