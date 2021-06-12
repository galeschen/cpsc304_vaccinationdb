/* todo: Nested aggregation with group-by
Pick one query that finds some aggregated value for each group (e.g. the average number of items purchased per customer).

Update file name.
*/

/* For each vaccine whose vaccine cost is below the average price of all vaccines, retrieve the Vaccine ID, what it
vaccinates for, and its name.*/
SELECT ID, VName, IsFor
FROM Vaccine
WHERE Price < (SELECT AVG(Price) FROM Vaccine))
GROUP BY IsFor;