/* CRITERIA: Join Query
Pick one query of this category, which joins at least two tables and performs a meaningful query.
Interface allows the user to choose this query 
(e.g., join the Customers and the Transactions table to find the phone numbers of all customers who has purchased a specific item).
*/

-- Join the nurse and works at table to find the names and IDs of all nurses who work at the given clinic --
SELECT Nurse.NName, Nurse.ID
FROM Nurse, WorksAt
WHERE Nurse.ID = WorksAt.NurseID AND ClinicID = '&ClinicID';