/* CRITERIA:
Update Operation
Interface allows the user to specify some input for the update operation.*/

-- Decreases vaccine availability. --
UPDATE Vaccine
SET VAvailability = (SELECT (VAvailability - &Decrement_Amount) from Vaccine Where ID = '&Vaccine_ID')
WHERE ID = '&Vaccine_ID';