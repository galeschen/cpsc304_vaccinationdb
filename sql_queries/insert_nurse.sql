/* Insert Operation
Interface allows the user to specify some input for the insert operation.
*/

/* Inserts a new nurse with given info */
INSERT INTO Nurse(ID, NName, NPassword)
VALUES (:Nurse_ID, :Nurse_Name, :Nurse_Password);