/* CRITERIA: Insert Operation
Interface allows the user to specify some input for the insert operation.
*/

/* Inserts a new appointment.*/
-- INSERT INTO Patient VALUES ($phn,'$name','$sex','$address','$postal',DATE '$birthday')
INSERT INTO VaccinationAppointment VALUES ('&AppointmentID', '&ClinicID', timestamp '&Time', &BookerPHN, &PatientPHN, '&NurseID', '&VaccineID');