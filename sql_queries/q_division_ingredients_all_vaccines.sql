/* CRITERIA: Division query
The interface allows the user to choose this query (e.g., find all the customers who bought all the items).
*/

-- Find the ingredients which are contained in all vaccines. --
SELECT i.IName 
From Ingredient i
where not exists
(select * from Vaccine v
where not exists
(select c.IngredientName
from contains c
where c.IngredientName=i.IName
AND c.VaccineID = v.ID
))
