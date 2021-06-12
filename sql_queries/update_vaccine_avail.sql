/* Update Operation
Interface allows the user to specify some input for the update operation.
Update name accordingly. */

/* Update vaccine availability.
VaccineID is user specified. */
/* TO DO: Maybe let the user specify by what amount to update the vaccine availability by? */

UPDATE Vaccine
SET VAvailability = (SELECT VAvailability - 1 from Vaccine Where ID = :Vaccine_ID)
WHERE ID = :Vaccine_ID;