/* CRITERIA: Division query
The interface allows the user to choose this query (e.g., find all the customers who bought all the items).
*/

-- TODO: THIS IS BROKEN! NOT SURE WHY --
-- Which nurses work at all clinics? (Realistically, none... but for the sake of this assignment....) --
SELECT * FROM Nurse
WHERE NOT EXISTS 
    ((SELECT Clinic.ID FROM Clinic)
    EXCEPT
    (SELECT WorksAt.ClinicID 
    FROM WorksAt
    WHERE WorksAt.NurseID = Nurse.ID));
