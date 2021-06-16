/* CRITERIA: Nested aggregation with group-by
Pick one query that finds some aggregated value for each group (e.g. the average number of items purchased per customer).
*/

/* Retrieves the vaccines whose costs are higher than the average price of all vaccines/*/
SELECT * FROM Vaccine WHERE Cost > (SELECT avg(Cost) from Vaccine)