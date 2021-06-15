/* CRITERIA: Selection
Create one query of this category. Provide an interface for the user to specify the selection conditions to be returned.
Example:
SELECT Field_01
FROM Table_01
WHERE Field_02 >= 0
*/

-- Returns the Vaccine name and Vaccine ID of vaccines that vaccinate against illness including user defined string --
SELECT VName, ID, isFor
FROM Vaccine
WHERE isFor LIKE '%&Includes_String%';