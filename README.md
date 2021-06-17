# project_m6i8r_u4c3b_y7i2b
## Description – what was accomplished?
An UI that provides access to a vaccination database for vaccination booking. It has four types of users: clinic managers, nurses, clerks, and patients. A set of different SQL queries for different user types are available through the website. Clerks help book vaccination appointments and update patient information. Patients can book their own appointments and view their upcoming appointments. Nurses can view their upcoming appointments. Managers can filter for various vaccines and edit the nurses at their clinic.

## How the final schema differed from the schema turned in, and why?
The final schema did not differ from the schema turned in, except for a few minor changes, such as changes to data types (e.g. data type for VaccinationAppointment.time from TIMESTAMP to DATE). These changes were made because the old data types caused errors, or the updated data types were easier to work with.

However, our GUI does not make use of all the relations in our schema. Most notably, it does not differentiate between minor and adult patients. Therefore, the relations isLinked and GuardianOf, which both describe the relationship between minor and adult patients, are not used. Another relation that is not used for our GUI is IsAllergicTo, which describes which patients are allergic to which ingredients.

These currently unused relations are still included in the SQL tables as they would be useful if/when more functionalities are added in. For instance, keeping the minor/adult schemas will make it easier to add in the functionality for guardians to book vaccination appointments for their children.
 


## This repository contains the following hand in requirements:
### All code used in the application

### /sql/sql_tables.sql
A single SQL script for creating all the tables and data in the database.

### /sql/sample_queries
Nine sample SQL queries, as outlined by the Milestone 5 criteria. Each file includes a query and a short description of its function.

### /screenshots/sample_queries
Screenshots of sample queries. 
This folder includes screenshots for the 9 sample queries from /sql/sql_queries.

For queries that are pre-loaded (i.e. are not queried by the user but executed when the page loads), a screenshot of the information loaded on the page is provided.
For queries that require user to select it, pre and post screenshots are provided.
