-- CRITERIA: Projection
-- Create one query of this category . Interface allows the user to specify the projection conditions to be returned.

-- Example:
-- SELECT Field_01
-- FROM Table_01


/* Select the names of the ingredients that contained in a particular vaccine. */
SELECT IngredientName FROM Contains where VaccineID = $VaccineInfo


