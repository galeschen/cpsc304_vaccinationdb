/* CRITERIA: Join Query
Pick one query of this category, which joins at least two tables and performs a meaningful query.
Interface allows the user to choose this query 
(e.g., join the Customers and the Transactions table to find the phone numbers of all customers who has purchased a specific item).
*/

-- Join the patient ,patient Address and patient Account to provide all patients' information to clerk
SELECT * FROM Patient
        INNER JOIN PatientAddress
        ON Patient.PostalCode = PatientAddress.PostalCode
        INNER JOIN PatientAccount
        ON Patient.PersonalHealthNumber = PatientAccount.PersonalHealthNumber