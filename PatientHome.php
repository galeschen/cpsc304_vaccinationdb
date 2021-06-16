<html>
    <head>
    <link rel="stylesheet" href = "./css/Patient.css">
        <title>CPSC 304 PHP/Patient Home</title>
    </head>
    <body>
    <br />
    <br />       

    <form method="POST"> 
        <h2>Reset Your Account Password</h2>
        New Password: <input type="text" name="RP_ppassword"> <br /><br />
        <input type="submit" value="Reset Password" name="updatePatientAccountPassword"></p>
    </form>   

    <form method="POST"> 
        <h2>Update Address</h2>
        Street Address: <input type="text" name="UA_StreetAddress"> <br /><br />
        Postal Code: <input type="text" name="UA_PostalCode"> <br /><br />
        City: <input type="text" name="UA_City"> <br /><br />
        <input type="submit" value="Update Address" name="updatePatientAccountAddress"></p>
    </form>   

        <?php
        include 'oracle_connection.php';
       
        function initialization(){
			// get patient username from last page
            if($_GET){
                $pusername = $_GET['pusername'];       
            }else{
              echo "Url has no user";
            }
            if (connectToDB()) {

				// GET PATIENT PHN: join patient and patientaccount
				$result = executePlainSQL("SELECT P.PersonalHealthNumber
				FROM Patient P, PatientAccount A
				WHERE A.Username = '$pusername'
				AND A.PersonalHealthNumber = P.PersonalHealthNumber");
				$phnResult = OCI_Fetch_Array($result, OCI_BOTH);
				$phn = $phnResult[0];

				// GET PATIENT NAME: join patient and patientaccount
				$result = executePlainSQL("SELECT P.PName
				FROM Patient P, PatientAccount A
				WHERE A.Username = '$pusername'
				AND A.PersonalHealthNumber = P.PersonalHealthNumber");
                $nameResult = OCI_Fetch_Array($result, OCI_BOTH);
                $name = $nameResult[0];
                
				// WELCOME STATEMENT
                echo "<h2>Welcome " . $name . "!</h2>";

                $result = executePlainSQL(
                    "SELECT * 
                    FROM Patient
                    WHERE Patient.PersonalHealthNumber = (
                        SELECT PersonalHealthNumber
                        FROM PatientAccount
                        WHERE Username = '$pusername'
                    )"
                );

                echo "<h2>Here is your information:</h2>";
                echo "<table>";
                echo "<tr>
                    <th>Personal Health Number</th>
                    <th>Name</th>
                    <th>Sex</th>
                    <th>Street Address</th>
                    <th>Postal Code</th>
                    <th>Date of Birth</th>
                </tr>";
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                    echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                        <td>" . $row[3] . "</td>
                        <td>" . $row[4] . "</td>
                        <td>" . $row[5] . "</td>
                    </tr>"; //or just use "echo $row[0]"
                }
                echo "</table>";

                // debugging
                // echo "<h3>(Debug) Welcome " . $phn . "!</h3>";
                
                // UPCOMING APPOINTMENTS
                // this is working.
                echo "<h2>This is your next vaccination appointment:</h2>";
				$result = executePlainSQL("SELECT Vaccine.VName AS Vaccine,
                    C.ClinicName AS Clinic, 
                    C.StreetAddress AS ClinicAddress, 
                    A.City AS ClinicCity,
                    V.Time AS AppointmentTime
					FROM VaccinationAppointment V, Clinic C, ClinicAddress A, Vaccine
					WHERE V.PatientPHN = $phn
                    AND C.ClinicID = V.ClinicID
                    AND A.PostalCode = C.PostalCode
                    AND V.VaccineID = Vaccine.ID");
                    
                    /*
                    if ($result[0] == NULL) {
                        echo "<h5>You have no upcoming appointments!</h5>";
                    }
                    */
                    // this is working
                    $i = 0;
                    while ($appointmentInfo = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo "<h5>Vaccine: $appointmentInfo[0]  <br />
                        Clinic: $appointmentInfo[1]  <br />
                        Address: $appointmentInfo[2], $appointmentInfo[3] <br />
                        Time: $appointmentInfo[4]</h5>";
                        $i += 1;
                    }
                    
                    if ($i == 0) {
                        echo "<h5>You have no upcoming appointments!</h5>";
                    }

                    $result = executePlainSQL(
                        "SELECT Vaccine.VName AS Vaccine,
                        C.ClinicName AS Clinic, 
                        C.StreetAddress AS ClinicAddress, 
                        A.City AS ClinicCity,
                        V.Time AS AppointmentTime
                        FROM VaccinationAppointment V, Clinic C, ClinicAddress A, Vaccine
                        WHERE V.PatientPHN = $phn
                        AND C.ClinicID = V.ClinicID
                        AND A.PostalCode = C.PostalCode
                        AND V.VaccineID = Vaccine.ID"
                    );

                    echo "<table>";
                    echo "<tr>
                        <th>Vaccine</th>
                        <th>Clinic</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Time</th>
                    </tr>";
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo "<tr>
                            <td>" . $row[0] . "</td>
                            <td>" . $row[1] . "</td>
                            <td>" . $row[2] . "</td>
                            <td>" . $row[3] . "</td>
                            <td>" . $row[4] . "</td>
                        </tr>"; //or just use "echo $row[0]"
                    }
                    echo "</table>";

				// BUTTON TO BOOK A NEW APPOINTMENT


				// BUTTON TO CANCEL AN APPOINTMENT.... if i have time
                disconnectFromDB();                
            }            
        }

        function updatePatientAccountPassword() {
            global $db_conn;
            $PatientUsername = $_GET['pusername'];
            $NewPassword = $_POST["RP_ppassword"];
            executePlainSQL("UPDATE PatientAccount SET ppassword = '$NewPassword' WHERE Username = '$PatientUsername'");
            echo "Password for '$PatientUsername' updated to '$NewPassword'<br>";
            OCICommit($db_conn);
        }

        // TODO: DOESNT WORK CORRECTLY
        function updatePatientAccountAddress() {
            echo "TESTING WORKING <br>";
            global $db_conn;
            $PatientUsername = $_GET['pusername'];
            
            $NewStreetAddress = $_POST['UA_StreetAddress'];
            $NewPostalCode = $_POST['UA_PostalCode'];
            $NewCity = $_POST['UA_City'];
            
            // TODO: MAKE IT CHECK IF POSTAL CODE ALREADY EXISTS FIRST
            /*
            executePlainSQL(
                "INSERT INTO PatientAddress(PostalCode, City)
                SELECT '$NewPostalCode', '$NewCity'
                WHERE NOT EXISTS(
                    SELECT *
                    FROM PatientAddress
                    WHERE PostalCode = '$NewPostalCode'
                )"
            );
            */
            
            executePlainSQL(
                "UPDATE Patient 
                SET StreetAddress = '$NewStreetAddress', PostalCode = '$NewPostalCode'
                WHERE PersonalHealthNumber = (
                    SELECT PersonalHealthNumber
                    FROM PatientAccount
                    WHERE Username = '$PatientUsername'
                )"
            );
            
            //echo "Address for '$PatientUsername' updated<br>";
            OCICommit($db_conn);
        }

        function handlePostRequest() {
            if (connectToDB()) {
                if (array_key_exists('updatePatientAccountPassword', $_POST)) {
                    updatePatientAccountPassword();
                }
                else if (array_key_exists('updatePatientAccountAddress', $_POST)) {
                    updatePatientAccountAddress();
                }
                disconnectFromDB();
            }
        }

        function handleloginRequest() {
            global $db_conn;
            
            OCICommit($db_conn);
        }

        initialization();
        handlePostRequest();
		?>

    <form method="POST" action="Vaccination.php"> <!--refresh page when submitted-->
    <input type="submit" value="Logout" name="logout"></p>
    </form>
	</body>
</html>