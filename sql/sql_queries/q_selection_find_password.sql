/* CRITERIA: Selection
Create one query of this category. Provide an interface for the user to specify the selection conditions to be returned.
Example:
SELECT Field_01
FROM Table_01
WHERE Field_02 >= 0
*/

--select the correct patient password from patient account whose username = user's input username--
SELECT ppassword FROM PatientAccount
where Username = :username;