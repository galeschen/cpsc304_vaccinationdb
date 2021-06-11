CREATE TABLE AssistsBooking(
    AppointmentID	CHAR(5),
    ClinicID		CHAR(5),
    ClerkID		    CHAR(5),
    PRIMARY KEY (AppointmentID, ClinicID, ClerkID),
    FOREIGN KEY (AppointmentID,ClinicID) REFERENCES BookingInfo
        ON DELETE CASCADE,
    FOREIGN KEY (ClerkID) REFERENCES ClericalStaff(ID)
      ON DELETE CASCADE
);
