DROP TABLE AssistsBooking;
DROP TABLE BookingInfo;
DROP TABLE VaccinationAppointment;
DROP TABLE VaccinePatient;
DROP TABLE Contains;
DROP TABLE IsAllergicTo;
DROP TABLE Vaccine;
DROP TABLE Ingredient;
DROP TABLE WorksAt;
DROP TABLE Clinic;
DROP TABLE Manager;
DROP TABLE Nurse;
DROP TABLE ClinicAddress;
DROP TABLE ClericalStaff;
DROP TABLE GuardianOf;
DROP TABLE IsLinkedTo;
DROP TABLE Adult;
DROP TABLE Minor;
DROP TABLE PatientAccount;
DROP TABLE Patient;
DROP TABLE PatientAddress;

CREATE TABLE Vaccine(
    ID              CHAR(5),
    VName           VARCHAR(30)     NOT NULL,
    IsFor           VARCHAR(30)     NOT NULL,
    Cost            DECIMAL         NOT NULL,
    VAvailability   INT             NOT NULL,   
    UNIQUE (VName),
    PRIMARY KEY (ID)
);

CREATE TABLE Ingredient(
        IName    VARCHAR(30),
        PRIMARY KEY (IName)
);

CREATE TABLE Manager(
    ID           CHAR(5),
    MName        VARCHAR(30)     NOT NULL,
    MPassword    VARCHAR(30)     NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE Contains(
    VaccineID       CHAR(5),
    IngredientName  VARCHAR(30),
    PRIMARY KEY     (VaccineID, IngredientName),
    FOREIGN KEY     (VaccineID) REFERENCES Vaccine(ID),
    FOREIGN KEY     (IngredientName) REFERENCES Ingredient(IName)
);

CREATE TABLE ClinicAddress(
    PostalCode	CHAR(6),
	City		VARCHAR(30),
	PRIMARY KEY (PostalCode)
);

CREATE TABLE Clinic(
    ClinicID        CHAR(5),
    ManagerID       CHAR(5),
    StreetAddress   VARCHAR(30)     NOT NULL,
    PostalCode      CHAR(6),
    ClinicName      VARCHAR(30)     NOT NULL,
    UNIQUE      (StreetAddress, ClinicName),
    PRIMARY KEY (ClinicID),
    FOREIGN KEY (PostalCode) REFERENCES ClinicAddress,
    FOREIGN KEY (ManagerID) REFERENCES Manager(ID)
        ON DELETE CASCADE
);

CREATE TABLE Nurse(
    ID           CHAR(5),
    NName        VARCHAR(30)    NOT NULL,
    NPassword    VARCHAR(30)    NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE WorksAt(
    NurseID     CHAR(5),
    ClinicID    CHAR(5),
    PRIMARY KEY (NurseID, ClinicID),
    FOREIGN KEY (NurseID) REFERENCES Nurse(ID)
        ON DELETE CASCADE,
    FOREIGN KEY (ClinicID) REFERENCES Clinic(ClinicID)
);

CREATE TABLE PatientAddress(
    PostalCode	CHAR(6),
	City		VARCHAR(30),
	PRIMARY KEY (PostalCode)
);

CREATE TABLE Patient(
	PersonalHealthNumber 	int,
	PName			        VARCHAR(30)	    NOT NULL,
	PSex				    CHAR(1)		    NOT NULL,
	StreetAddress		    VARCHAR(30)	    NOT NULL,
	PostalCode			    CHAR(6)		    NOT NULL,
	DateOfBirth			    date			NOT NULL,
    PRIMARY KEY (PersonalHealthNumber),
	FOREIGN KEY (PostalCode) REFERENCES PatientAddress
);

CREATE TABLE Adult(
    PersonalHealthNumber	int,
    PRIMARY KEY (PersonalHealthNumber),
    FOREIGN KEY (PersonalHealthNumber) REFERENCES Patient(PersonalHealthNumber)
        ON DELETE CASCADE
);

CREATE TABLE VaccinePatient (
	VaccineID			    CHAR(5),
	PatientPHN			    int,
	RemainingDoses		    INT		NOT NULL,
	ImmunityExpirationDate	DATE,
	PRIMARY KEY (VaccineID, PatientPHN),
	FOREIGN KEY (VaccineID) REFERENCES Vaccine
		ON DELETE CASCADE,
	FOREIGN KEY (PatientPHN) REFERENCES Patient(PersonalHealthNumber)
		ON DELETE CASCADE
);

CREATE TABLE VaccinationAppointment( 
    AppointmentID 	CHAR(5),
    ClinicID 		CHAR(5),
    Time		    TIMESTAMP	NOT NULL,
    BookerPHN		int		    NOT NULL,
    PatientPHN		int 	    NOT NULL,
    NurseID		    CHAR(5)	    NOT NULL,
    VaccineID		CHAR(5)	    NOT NULL,
    PRIMARY KEY(AppointmentID, ClinicID),
    FOREIGN KEY(ClinicID) REFERENCES Clinic(ClinicID),
    FOREIGN KEY(BookerPHN) REFERENCES Adult(PersonalHealthNumber)
        ON DELETE CASCADE,
    FOREIGN KEY(VaccineID,PatientPHN) REFERENCES VaccinePatient
        ON DELETE CASCADE,
    FOREIGN KEY(NurseID) REFERENCES Nurse(ID)
        ON DELETE CASCADE
);

CREATE TABLE ClericalStaff(
	ID		    CHAR(5),
	Password	VARCHAR(30) 	NOT NULL,
	CName		VARCHAR(30)	    NOT NULL,
	PRIMARY KEY (ID)
);

CREATE TABLE BookingInfo(
    AppointmentID	CHAR(5),
    ClinicID		CHAR(5),
    BookerPHN		int		NOT NULL,
    PRIMARY KEY (AppointmentID, ClinicID),
    FOREIGN KEY (AppointmentID,ClinicID) REFERENCES VaccinationAppointment
            ON DELETE CASCADE,
    FOREIGN KEY (BookerPHN) REFERENCES Patient(PersonalHealthNumber)
);

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

CREATE TABLE Minor(
    PersonalHealthNumber	int,
    PRIMARY KEY (personalHealthNumber),
    FOREIGN KEY (personalHealthNumber) REFERENCES Patient(PersonalHealthNumber)
		ON DELETE CASCADE
);

CREATE TABLE IsAllergicTo(
	IngredientName		    VARCHAR(30),
	PersonalHealthNumber	int,
	PRIMARY KEY (IngredientName, PersonalHealthNumber),
	FOREIGN KEY (IngredientName) REFERENCES Ingredient(IName)
		ON DELETE CASCADE,
	FOREIGN KEY (PersonalHealthNumber) REFERENCES Patient(PersonalHealthNumber)
        ON DELETE CASCADE
);

CREATE TABLE PatientAccount(
	Username			    VARCHAR(20),
	ppassword			    VARCHAR(30)		NOT NULL,
	PersonalHealthNumber	int			    NOT NULL,
	UNIQUE (PersonalHealthNumber),
	PRIMARY KEY (Username),
	FOREIGN KEY (PersonalHealthNumber) REFERENCES Patient
    ON DELETE CASCADE
);

CREATE TABLE GuardianOf (
	GuardianPHN		    int,
	DependentPHN	    int,
	PRIMARY KEY (GuardianPHN, DependentPHN),
	FOREIGN KEY (GuardianPHN) REFERENCES Adult(PersonalHealthNumber),
	FOREIGN KEY (DependentPHN) REFERENCES Minor(PersonalHealthNumber)
		ON DELETE CASCADE
);

CREATE TABLE IsLinkedTo(
	dependentUsername		VARCHAR(20),
	guardianUsername		VARCHAR(20),
	PRIMARY KEY (dependentUsername, guardianUsername),
    FOREIGN KEY (dependentUsername) REFERENCES PatientAccount(Username)
		ON DELETE CASCADE,
    FOREIGN KEY (guardianUsername) REFERENCES PatientAccount(Username)
);

INSERT INTO Vaccine
VALUES ('VV381', 'Vaxchora', 'Cholera', '50.00', 3230); 
INSERT INTO Vaccine
VALUES ('VH721', 'Havrix', 'Hepatitis A', '30.00', 50); 
INSERT INTO Vaccine
VALUES ('VH722', 'Vaqta', 'Hepatitis A', '30.00', 50);
INSERT INTO Vaccine
VALUES ('VR821', 'RabAvert', 'Rabies', '70.00', 2803); 
INSERT INTO Vaccine
VALUES ('VV341', 'Vivotif', 'Typhoid', '60.00', 1340); 
INSERT INTO Vaccine
VALUES ('VG921', 'Gardasil', 'Human Papillomavirus (HPV)', '25.00', 2130); 

INSERT INTO Ingredient
VALUES ('Aluminum phosphate');
INSERT INTO Ingredient
VALUES ('Sucrose');
INSERT INTO Ingredient
VALUES ('Sodium');
INSERT INTO Ingredient
VALUES ('Neomycin');
INSERT INTO Ingredient
VALUES ('Gelatin');
INSERT INTO Ingredient
VALUES ('Water');

INSERT INTO Manager
VALUES ('M4133','Marcus Cutter', 'mmmchailatte');
INSERT INTO Manager
VALUES ('M2346','Isabel Lovelace', 'geneticallymodifiedturnips');
INSERT INTO Manager
VALUES ('M2455','Warren Kepler', 'ethicalconcerns');
INSERT INTO Manager
VALUES ('M2896','Alana Maxwell', 'dadistpoetry');
INSERT INTO Manager
VALUES ('M3456', 'Miranda Pryce', 'sentientbutter');

INSERT INTO Contains
VALUES ('VV381','Neomycin');
INSERT INTO Contains
VALUES ('VH721','Sodium');
INSERT INTO Contains
VALUES ('VR821','Neomycin');
INSERT INTO Contains
VALUES ('VR821','Sucrose');
INSERT INTO Contains
VALUES ('VR821','Aluminum phosphate');

-- All vaccines contain water --
INSERT INTO Contains
VALUES ('VV381','Water');
INSERT INTO Contains
VALUES ('VH721','Water');
INSERT INTO Contains
VALUES ('VH722','Water');
INSERT INTO Contains
VALUES ('VR821','Water');
INSERT INTO Contains
VALUES ('VV341','Water');
INSERT INTO Contains
VALUES ('VG921','Water');

INSERT INTO Nurse
VALUES ('NJ384','Jane Prentiss', 'ohworms');
INSERT INTO Nurse
VALUES ('NE291','Elias Bouchard', '3y3b4lls');
INSERT INTO Nurse
VALUES ('NA324','Agnes Montague', 'cand!ewax');
INSERT INTO Nurse
VALUES ('ND342','Georgie Barker', 'whattheghost');
INSERT INTO Nurse
VALUES ('NJ034','Jude Perry', 'forestf!res');

INSERT INTO ClinicAddress
VALUES ('V7M3E4', 'Richmond');
INSERT INTO ClinicAddress
VALUES ('V5X0A1', 'Vancouver');
INSERT INTO ClinicAddress
VALUES ('V5T2T7', 'Vancouver');
INSERT INTO ClinicAddress
VALUES ('V6G2L8', 'Burnaby');
INSERT INTO ClinicAddress
VALUES ('V5T4V5', 'Vancouver');

INSERT INTO Clinic
VALUES ('CL597', 'M4133', '3075 Slocan st.', 'V7M3E4', 'Italian Cultural Centre');
INSERT INTO Clinic
VALUES ('CL578', 'M2346', '6810 Main St.', 'V5X0A1', 'Sunset Community Centre');
INSERT INTO Clinic
VALUES ('CL786', 'M2455', '1155 E. Broadway', 'V5T4V5', 'VCC Lot #865');
INSERT INTO Clinic
VALUES ('CL695', 'M2896', '1 Athletes Way', 'V5T4V5', 'Creekside Community Centre');
INSERT INTO Clinic
VALUES ('CL358', 'M3456', '870 Denman St.', 'V5X0A1', 'West End Community Centre');

INSERT INTO WorksAt
VALUES ('NJ384','CL597');
INSERT INTO WorksAt
VALUES ('NA324','CL578');
INSERT INTO WorksAt
VALUES ('ND342','CL597');
INSERT INTO WorksAt
VALUES ('NJ034','CL358');
INSERT INTO WorksAt
VALUES ('NA324','CL786');
INSERT INTO WorksAt
VALUES ('NA324','CL358');
INSERT INTO WorksAt
VALUES ('NE291','CL597');
INSERT INTO WorksAt
VALUES ('NE291','CL578');
INSERT INTO WorksAt
VALUES ('NE291','CL786');
INSERT INTO WorksAt
VALUES ('NE291','CL695');
INSERT INTO WorksAt
VALUES ('NE291','CL358');

INSERT INTO PatientAddress
VALUES ('N9V8B2', 'Nightvale');
INSERT INTO PatientAddress
VALUES ('N9V5B2', 'Nightvale');
INSERT INTO PatientAddress
VALUES ('D8B7V3', 'Desert Bluffs');
INSERT INTO PatientAddress
VALUES ('V7E8R3', 'Richmond');
INSERT INTO PatientAddress
VALUES ('V5F3G2', 'Vancouver');

INSERT INTO Patient
VALUES (3234842, 'Doug Eiffel', 'M', '3942 Spire St', 'N9V8B2', DATE '1979-12-03');
INSERT INTO Patient
VALUES (3425352, 'Daniel Jacobi', 'M', '9382 Walnut Rd', 'N9V8B2', DATE '1982-07-23');
INSERT INTO Patient
VALUES (0592834, 'Hera Douglas', 'F', '3942 Smiling St', 'D8B7V3', DATE '2013-02-19');
INSERT INTO Patient
VALUES (3927384, 'Sophie Kaner', 'F', '8293 Birney Ave', 'V5F3G2', DATE '1989-05-12');
INSERT INTO Patient
VALUES (3304923, 'Kate Werner', 'F', '9342 Alberta St', 'N9V8B2', DATE '1986-04-21');
INSERT INTO Patient
VALUES (2309571, 'Buddy Aurinko', 'F', '9305 Lemming Rd', 'D8B7V3', DATE '1968-07-23');
INSERT INTO Patient
VALUES (0984632, 'Nile Freeman', 'F', '3920 No.3 Rd', 'V7E8R3', DATE '2019-03-02');
INSERT INTO Patient
VALUES (0572712, 'Sebastian Booker', 'M', '3920 No.3 Rd', 'V7E8R3', DATE '2014-09-24');
INSERT INTO Patient
VALUES (0820183, 'Juno Steel', 'M', '9305 Lemming Rd', 'D8B7V3', DATE '2013-05-07');
INSERT INTO Patient
VALUES (0829573, 'Peter Nureyev', 'M', '9305 Lemming Rd', 'D8B7V3', DATE '2009-07-15');

INSERT INTO Adult
VALUES (3234842);
INSERT INTO Adult
VALUES (3425352);
INSERT INTO Adult
VALUES (3927384);
INSERT INTO Adult
VALUES (3304923);
INSERT INTO Adult
VALUES (2309571);

INSERT INTO VaccinePatient
VALUES ('VV381', 3234842, 0, Date '2029-01-23');
INSERT INTO VaccinePatient
VALUES ('VV381', 3304923, 1, Date '2023-12-1');
INSERT INTO VaccinePatient
VALUES ('VR821', 2309571, 2, Date '2022-3-24');
INSERT INTO VaccinePatient
VALUES ('VR821', 0820183, 1, Date '2024-1-28');
INSERT INTO VaccinePatient
VALUES ('VR821', 0829573, 1, Date '2034-8-12');

INSERT INTO VaccinationAppointment
VALUES ('A3942', 'CL597', timestamp '2021-07-29 10:00:00', 3234842, 3234842, 'NJ384', 'VV381');
INSERT INTO VaccinationAppointment
VALUES ('A0395', 'CL578', timestamp '2021-05-09 09:30:00', 2309571, 2309571, 'NA324', 'VR821');
INSERT INTO VaccinationAppointment
VALUES ('A3843', 'CL786', timestamp '2021-06-29 15:45:00', 2309571, 0820183, 'NA324', 'VR821');
INSERT INTO VaccinationAppointment
VALUES ('A3748', 'CL358', timestamp '2021-06-30 16:00:00', 2309571, 0829573, 'NA324', 'VR821');
INSERT INTO VaccinationAppointment
VALUES ('A3963', 'CL358', timestamp '2021-06-30 16:15:00', 3304923, 3304923, 'NE291', 'VV381');

INSERT INTO ClericalStaff
VALUES ('CS345', 'MyClarinet', 'Squidward Tentacles');
INSERT INTO ClericalStaff
VALUES ('CS356', 'MoneyMoneyMoney', 'Eugene Krabs');
INSERT INTO ClericalStaff
VALUES ('CS557', 'TexasHome', 'Sandy Cheeks');
INSERT INTO ClericalStaff
VALUES ('CS456', 'KrabbyPatties', 'Karen Plankton');
INSERT INTO ClericalStaff
VALUES ('CS968', 'TexasStupid', 'Patrick Star');

INSERT INTO BookingInfo
VALUES ('A3942', 'CL597', 3234842);
INSERT INTO BookingInfo
VALUES ('A0395', 'CL578', 3425352);
INSERT INTO BookingInfo
VALUES ('A3843', 'CL786', 3927384);
INSERT INTO BookingInfo
VALUES ('A3748', 'CL358', 3304923);
INSERT INTO BookingInfo
VALUES ('A3963', 'CL358', 2309571);

INSERT INTO AssistsBooking
VALUES ('A3942', 'CL597', 'CS345');
INSERT INTO AssistsBooking
VALUES ('A0395', 'CL578', 'CS356');
INSERT INTO AssistsBooking
VALUES ('A3843', 'CL786', 'CS557');
INSERT INTO AssistsBooking
VALUES ('A3748', 'CL358', 'CS456');
INSERT INTO AssistsBooking
VALUES ('A3963', 'CL358', 'CS968');

INSERT INTO Minor
VALUES (0592834);
INSERT INTO Minor
VALUES (0984632);
INSERT INTO Minor
VALUES (0572712);
INSERT INTO Minor
VALUES (0820183);
INSERT INTO Minor
VALUES (0829573);

INSERT INTO IsAllergicTo
VALUES ('Gelatin',0592834);
INSERT INTO IsAllergicTo
VALUES ('Neomycin',3425352);
INSERT INTO IsAllergicTo
VALUES ('Aluminum phosphate',3927384);
INSERT INTO IsAllergicTo
VALUES ('Neomycin',3304923);
INSERT INTO IsAllergicTo
VALUES ('Gelatin',0829573);

INSERT INTO PatientAccount
VALUES ('eiffel359', 'dearlisteners',3234842);
INSERT INTO PatientAccount
VALUES ('daniel359', 'ohnoducks',3425352);
INSERT INTO PatientAccount
VALUES ('sophiepod', 'penumbra',3927384);
INSERT INTO PatientAccount
VALUES ('katepod', 'genericpassword',3304923);
INSERT INTO PatientAccount
VALUES ('msbuddy', 'crimefamily',2309571);
INSERT INTO PatientAccount
VALUES ('hera359', 'password32155',0592834);
INSERT INTO PatientAccount
VALUES ('niletog', 'eggboy!394',0984632);
INSERT INTO PatientAccount
VALUES ('lelivre', 'biblically',0572712);
INSERT INTO PatientAccount
VALUES ('mxjuno', 'privateeye',0820183);
INSERT INTO PatientAccount
VALUES ('noname', 'angelofbrahma',0829573);

INSERT INTO GuardianOf
VALUES (3234842, 0592834);
INSERT INTO GuardianOf
VALUES (3425352, 0984632);
INSERT INTO GuardianOf
VALUES (3927384, 0572712);
INSERT INTO GuardianOf
VALUES (3304923, 0820183);
INSERT INTO GuardianOf
VALUES (2309571, 0829573);

INSERT INTO IsLinkedTo
VALUES ('mxjuno', 'msbuddy');
INSERT INTO IsLinkedTo
VALUES ('noname', 'msbuddy');
INSERT INTO IsLinkedTo
VALUES ('hera359', 'daniel359');
INSERT INTO IsLinkedTo
VALUES ('lelivre', 'daniel359');
INSERT INTO IsLinkedTo
VALUES ('niletog', 'daniel359');