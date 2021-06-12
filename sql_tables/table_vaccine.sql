CREATE TABLE Vaccine(
    ID              CHAR(5),
    VName           VARCHAR(30)     NOT NULL,
    IsFor             VARCHAR(30)     NOT NULL,
    Cost            DECIMAL      NOT NULL,
    VAvailability   INT             NOT NULL,   
    UNIQUE (VName),
    PRIMARY KEY (ID)
);


    