/* Update Operation
Interface allows the user to specify some input for the update operation.
Update name accordingly. */

/* Decreases the availability of vaccine with given ID */
/* TODO: Want to make it so that the user can also specify the amount to decrease the availability by...*/

UPDATE Vaccine
SET VAvailability = (SELECT VAvailability - 1 from Vaccine Where ID = :Vaccine_ID)
WHERE ID = :Vaccine_ID;
