/* CRITERIA: Nested aggregation with group-by
Pick one query that finds some aggregated value for each group (e.g. the average number of items purchased per customer).
*/

/* Retrieves the average price of all vaccines that vaccinate against each illness/*/
SELECT IsFor, AVG(Cost)
FROM Vaccine
GROUP BY IsFor;