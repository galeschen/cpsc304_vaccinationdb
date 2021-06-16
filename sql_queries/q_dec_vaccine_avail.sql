/* CRITERIA:
Update Operation
Interface allows the user to specify some input for the update operation.*/

-- Update a given patient's remaining doses and immunity expiration date of a given vaccine. --
UPDATE VaccinePatient 
SET RemainingDoses = '$RemainingDoses', ImmunityExpirationDate = DATE '$ImmunityExpirationDate' 
WHERE VaccineID = '$VaccineID' 
AND PatientPHN = '$PatientPHN