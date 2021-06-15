<html>
    <head>
        <title>CPSC 304 PHP/Clerk Main Page</title>
    </head>

    <style>
    h2 {text-align: center;}
    form {text-align: center;}
    </style>
    <body>
    <br />
    <br />
        <h2>Clerk</h2>

        <hr />
        <br />
        <br />
        <br />
        <br />

        <form method="POST" action="Vaccination.php">
            <input type="submit" value="Exit" name="Exit"></p>
        </form>

        <form method="POST" action="ClerkHome.php">
            <input type="submit" value="printVaccineAppointments" name="printVaccineAppointments"></p>
        </form>

        <br />
        <?php
        include 'oracle_connection.php';
        function printVaccineAppointments() {
            $result = executePlainSQL("SELECT * FROM VaccinationAppointment");
            echo "<table>";
            echo "<tr>
                    <th>AppointmentID</th>
                    <th>ClinicID</th>
                    <th>Time</th>
                    <th>BookerPHN</th>
                    <th>PatientPHN</th>
                    <th>NurseID</th>
                    <th>VaccineID</th>
                </tr>";
            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr>
                        <td>" . $row["APPOINTMENTID"] . "</td>
                        <td>" . $row["CLINICID"] . "</td>
                        <td>" . $row["TIME"] . "</td>
                        <td>" . $row["BOOKERPHN"] . "</td>
                        <td>" . $row["PATIENTPHN"] . "</td>
                        <td>" . $row["NURSEID"] . "</td>
                        <td>" . $row["VACCINEID"] . "</td>
                    </tr>";
            }
            echo "</table>";
            OCICommit($db_conn);
        }

        // HANDLE ALL POST ROUTES
	    function handlePostRequest() {
            if (connectToDB()) {
                if (array_key_exists('printVaccineAppointments', $_POST)) {
                    printVaccineAppointments();
                    disconnectFromDB();
                }
            }
        }

        if (isset($_POST['printVaccineAppointments'])) {
            handlePostRequest();
        }
		?>

	</body>
</html>

