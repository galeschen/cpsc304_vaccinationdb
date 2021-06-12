/* Update Operation
Interface allows the user to specify some input for the update operation.
Update name accordingly. */

/* Function updates the street address in table Patient for the patient with given PHN.
PHN, New street address and new postal code are user specified.*/
/* TODO (to figure out): What happens if the new postal code isn't yet in Patientaddress? */
UPDATE Patient
SET StreetAddress = :New_Street_Address, PostalCode = :New_Postal_Code
WHERE PersonalHealthNumber = :Personal_Health_Number;