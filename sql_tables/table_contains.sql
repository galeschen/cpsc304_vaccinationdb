CREATE TABLE Contains(
    VaccineID       CHAR(5),
    IngredientName  VARCHAR(30),
    PRIMARY KEY     (VaccineID, IngredientName),
    FOREIGN KEY     (VaccineID) REFERENCES Vaccine(ID)
        ON DELETE CASCADE,
    FOREIGN KEY     (IngredientName) REFERENCES Ingredient(Name)
        ON DELETE NO ACTION
);