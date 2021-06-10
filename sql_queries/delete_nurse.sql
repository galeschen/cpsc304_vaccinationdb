/*Implement a cascade-on-delete situation. 
Provide an interface for the user to specify some input for the deletion operation. 
Based on input, deletion should be performed. */

/* Delete nurse with given Nurse ID */
DELETE FROM Nurse WHERE ID = :Nurse_ID;