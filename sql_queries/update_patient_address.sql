/* Update Operation
Interface allows the user to specify some input for the update operation.
Update name accordingly. */

/* Update patient address */

/* UpFunction updates the street address in table Patient for the patient with given PHN.*/
/* TODO (to figure out): What happens if the new postal code isn't yet in Patientaddress? */
UPDATE Patient
SET StreetAddress = :New_Street_Address, PostalCode = :New_Postal_Code
WHERE PersonalHealthNumber = :Personal_Health_Number;



/* Old update code
UPDATE Vaccine
SET VAvailability = (SELECT VAvailability - 1 from Vaccine Where ID = :Vaccine_ID)
WHERE ID = :Vaccine_ID;
*/
