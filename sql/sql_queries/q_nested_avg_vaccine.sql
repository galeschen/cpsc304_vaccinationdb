/* CRITERIA: Nested aggregation with group-by
Pick one query that finds some aggregated value for each group (e.g. the average number of items purchased per customer).
*/

/* Retrieves the disease targeted by the vaccines and its average costs which are higher than the average costs of all vaccine/*/
SELECT v.IsFor,avg(Cost) from Vaccine v group by IsFor having avg(cost)>(SELECT avg(cost) FROM Vaccine)