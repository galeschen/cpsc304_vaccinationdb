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

        
        
        <form method="POST"> 
            <h2>Select Patient's Vaccine Profile</h2>
            Vaccine ID: <input type="text" name="VP_VaccineID"> <br /><br />
            Patient's PHN: <input type="number" name="VP_PatientPHN"> <br /><br />
            <h2>Changes to Patient's Vaccine Profile:</h2>
            Remaining Doses: <input type="number" name="VP_RemainingDoses"> <br /><br />
            Immunity Expiration Date: <input type="date" name = "VP_ImmunityExpirationDate"> <br /> <br /> 

            <input type="submit" value="Change Vaccination Status of Patient" name="changeVaccinationStatus">
        </form>

        <hr />

        <form method="POST"> 
            <h2>Reset Patient's Account Password</h2>
            Username: <input type="text" name="RP_Username"> <br /><br />
            
            New Password: <input type="text" name="RP_ppassword"> <br /><br />

            <input type="submit" value="Reset Password" name="updatePatientAccountPassword"></p>
        </form>

        <hr />

        <form method="POST" action="Vaccination.php">
            <input type="submit" value="Exit" name="Exit"></p>
        </form>

        <form method="POST" action="ClerkHome.php">
            <input type="submit" value="Show all Vaccination Appointments" name="printAllVaccineAppointments"></p>
        </form>

        <form method="POST" action="ClerkHome.php">
            <input type="submit" value="Show all Patients" name="printAllPatients"></p>
        </form>

        <hr />
    

        <br />
        <?php
        include 'oracle_connection.php';
        function printAllVaccineAppointments() {
            global $db_conn;
            $result = executePlainSQL(
                "SELECT * 
                FROM VaccinationAppointment
                FULL OUTER JOIN VaccinePatient
                ON VaccinationAppointment.PatientPHN = VaccinePatient.PatientPHN"
            );
            echo "<table>";
            echo "<tr>
                    <th>Appointment ID</th>
                    <th>Clinic ID</th>
                    <th>Time</th>
                    <th>Booker PHN</th>
                    <th>Patient PHN</th>
                    <th>Nurse ID</th>
                    <th>Vaccine ID</th>
                    <th>Remaining Doses Required</th>
                    <th>Immunity Expiration Date</th>
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
                        <td>" . $row["REMAININGDOSES"] . "</td>
                        <td>" . $row["IMMUNITYEXPIRATIONDATE"] . "</td>
                    </tr>";
            }
            echo "</table>";
            OCICommit($db_conn);
        }

        function printAllPatients() {
            global $db_conn;
            $result = executePlainSQL(
                "SELECT * 
                FROM Patient
                INNER JOIN PatientAddress
                ON Patient.PostalCode = PatientAddress.PostalCode
                INNER JOIN PatientAccount
                ON Patient.PersonalHealthNumber = PatientAccount.PersonalHealthNumber"
            );
            echo "<table>";
            echo "<tr>
                    <th>Personal Health Number</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Sex</th>
                    <th>Address</th>
                    <th>Postal Code</th>
                    <th>City</th>
                    <th>Date of Birth</th>
                </tr>";
            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr>
                        <td>" . $row["PERSONALHEALTHNUMBER"] . "</td>
                        <td>" . $row["PNAME"] . "</td>
                        <td>" . $row["USERNAME"] . "</td>
                        <td>" . $row["PSEX"] . "</td>
                        <td>" . $row["STREETADDRESS"] . "</td>
                        <td>" . $row["POSTALCODE"] . "</td>
                        <td>" . $row["CITY"] . "</td>
                        <td>" . $row["DATEOFBIRTH"] . "</td>
                    </tr>";
            }
            echo "</table>";
            OCICommit($db_conn);
        }

        // TODO: MAKE IT WORK FOR DATE TOO
        function changeVaccinationStatus() {
            global $db_conn;
            $VaccineID = $_POST["VP_VaccineID"];
            $PatientPHN = $_POST["VP_PatientPHN"];
            $RemainingDoses = $_POST["VP_RemainingDoses"];
            $ImmunityExpirationDate = $_POST["VP_ImmunityExpirationDate"];
            executePlainSQL(
                "UPDATE VaccinePatient 
                SET RemainingDoses = '$RemainingDoses', ImmunityExpirationDate = DATE '$ImmunityExpirationDate' 
                WHERE VaccineID = '$VaccineID' 
                AND PatientPHN = '$PatientPHN'"
            );
            echo "Vaccination status updated<br>";
            OCICommit($db_conn);
        }

        function updatePatientAccountPassword() {
            global $db_conn;
            $PatientUsername = $_POST["RP_Username"];
            $NewPassword = $_POST["RP_ppassword"];
            executePlainSQL("UPDATE PatientAccount SET ppassword = '$NewPassword' WHERE Username = '$PatientUsername'");
            echo "Password for '$PatientUsername' updated to '$NewPassword'<br>";
            OCICommit($db_conn);
        }

        // HANDLE ALL POST ROUTES
	    function handlePostRequest() {
            if (connectToDB()) {
                if (array_key_exists('printAllVaccineAppointments', $_POST)) {
                    printAllVaccineAppointments();
                }
                else if (array_key_exists('changeVaccinationStatus', $_POST)) {
                    changeVaccinationStatus();
                }
                else if (array_key_exists('updatePatientAccountPassword', $_POST)) {
                    updatePatientAccountPassword();
                }
                else if (array_key_exists('printAllPatients', $_POST)) {
                    printAllPatients();
                }

                disconnectFromDB();
            }
        }
        handlePostRequest();
        /*
        if (isset($_POST['printAllVaccineAppointments'])) {
            handlePostRequest();
        }
        */
		?>

	</body>
</html>

