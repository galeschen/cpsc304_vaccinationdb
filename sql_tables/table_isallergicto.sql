CREATE TABLE IsAllergicTo(
	IngredientName		    VARCHAR(30),
	PersonalHealthNumber	int,
	PRIMARY KEY (IngredientName, PersonalHealthNumber),
	FOREIGN KEY (IngredientName) REFERENCES Ingredient(IName)
		ON DELETE CASCADE,
	FOREIGN KEY (PersonalHealthNumber) REFERENCES Patient(PersonalHealthNumber)
        ON DELETE CASCADE
);
