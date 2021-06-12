/* Update Operation
Interface allows the user to specify some input for the update operation.
Update name accordingly. */

/* Update patient address */

UPDATE Vaccine
SET VAvailability = (SELECT VAvailability - 1 from Vaccine Where ID = :Vaccine_ID)
WHERE ID = :Vaccine_ID;