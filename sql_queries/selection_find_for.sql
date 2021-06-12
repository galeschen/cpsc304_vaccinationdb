/* todo: Selection
Create one query of this category. Provide an interface for the user to specify the selection conditions to be returned.

Example:
SELECT Field_01
FROM Table_01
WHERE Field_02 >= 0

Update file name.
*/

/* Function selects information on all vaccines for which the illness it protects against includes user-specificed phrase. 
:Includes is user specified.*/
SELECT *
FROM Vaccine
WHERE IsFor LIKE :Includes;