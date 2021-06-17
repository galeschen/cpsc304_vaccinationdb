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

    <form method="POST"> 
        <input type="submit" value="Show Appointment Booking Info" name="printBookingInfo"></p>
    </form>

    <form method="POST"> 
        <h2>Book Appointment</h2>
        Appointment ID: <input type="text" placeholder="5 Digits Max" name="BA_AppointmentID"> <br /><br />
        Clinic ID: <input type="text" placeholder="Pick from Available" name="BA_ClinicID"> <br /><br />
        Date and Time: <input type="datetime-local" name="BA_Time"> <br /><br />
        Patient PHN: <input type="text" name="BA_PatientPHN"> <br /><br />
        Nurse ID: <input type="text" placeholder="Pick from Available" name="BA_NurseID"> <br /><br />
        Vaccine ID: <input type="text" placeholder="Pick from Available" name="BA_VaccineID"> <br /><br />
        <input type="submit" value="Book Appointment" name="bookAppointment"></p>
    </form>

    <form method="POST"> 
        <h2>Cancel Appointment</h2>
        Appointment ID: <input type="text" placeholder="Select from appointment" name="CA_AppointmentID"> <br /><br />
        Clinic ID: <input type="text" placeholder="Select from appointment" name="CA_ClinicID"> <br /><br />
        <input type="submit" value="Cancel Appointment" name="cancelAppointment"></p>
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
                        "SELECT AppointmentID AS ID,
                        C.ClinicID AS CID,
                        Vaccine.VName AS Vaccine,
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
                        <th>Appointment ID</th>
                        <th>Clinic ID</th>
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
                            <td>" . $row[5] . "</td>
                            <td>" . $row[6] . "</td>
                        </tr>"; //or just use "echo $row[0]"
                    }
                    echo "</table>";

				// BUTTON TO BOOK A NEW APPOINTMENT


				// BUTTON TO CANCEL AN APPOINTMENT.... if i have time
                disconnectFromDB();                
            }            
        }

        function cancelAppointment() {
            global $db_conn;
            $AppointmentIDToCancel = $_POST['CA_AppointmentID'];
            $ClinicIDToCancel = $_POST['CA_ClinicID'];
            executePlainSQL(
                "DELETE FROM VaccinationAppointment
                WHERE AppointmentID = '$AppointmentIDToCancel' AND ClinicID = '$ClinicIDToCancel'"
            );
            echo "Appointment cancelled<br>";
            OCICommit($db_conn);
        }

        // TODO: DEAL IWTH integrity constraint (ORA_ICA29.SYS_C00403362) violated ERROR
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
            global $db_conn;
            $PatientUsername = $_GET['pusername'];
            
            $NewStreetAddress = $_POST['UA_StreetAddress'];
            $NewPostalCode = $_POST['UA_PostalCode'];
            $NewCity = $_POST['UA_City'];


            if (executePlainSQL("SELECT COUNT(*) FROM PatientAddress WHERE PostalCode = $NewPostalCode") == 0) {
                executePlainSQL(
                    "INSERT INTO PatientAddress (PostalCode, City)
                    VALUES('$NewPostalCode', '$NewCity')"
                );
            }
            
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

        function printBookingInfo() {
            global $db_conn;
            $result = executePlainSQL(
                "SELECT * 
                FROM Clinic
                LEFT OUTER JOIN PatientAddress
                ON Clinic.PostalCode = PatientAddress.PostalCode"
            );
            echo "<table><caption>Clinics</caption>";
            echo "<tr>
                    <th>Clinic ID</th>
                    <th>Clinic</th>
                    <th>Address</th>
                </tr>";
            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr>
                        <td>" . $row["CLINICID"] . "</td>
                        <td>" . $row["CLINICNAME"] . "</td>
                        <td>" . $row["STREETADDRESS"] . "</td>
                    </tr>";
            }
            echo "</table>";

            $result = executePlainSQL(
                "SELECT * 
                FROM Nurse"
            );
            echo "<table><caption>Nurses</caption>";
            echo "<tr>
                    <th>Nurse ID</th>
                    <th>Name</th>
                </tr>";
            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr>
                        <td>" . $row["ID"] . "</td>
                        <td>" . $row["NNAME"] . "</td>
                    </tr>";
            }
            echo "</table>";

            $result = executePlainSQL(
                "SELECT * 
                FROM Vaccine"
            );
            echo "<table><caption>Vaccines</caption>";
            echo "<tr>
                    <th>Vaccine ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price ($)</th>
                </tr>";
            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr>
                        <td>" . $row["ID"] . "</td>
                        <td>" . $row["VNAME"] . "</td>
                        <td>" . $row["ISFOR"] . "</td>
                        <td>" . $row["COST"] . "</td>
                    </tr>";
            }
            echo "</table>";

            OCICommit($db_conn);
        }

        // TODO: NOT WORKING CORRECTLY
        function bookAppointment() {
            global $db_conn;
            $AppointmentID = $_POST["BA_AppointmentID"];
            $ClinicID = $_POST["BA_ClinicID"];
            $DateAndTime = $_POST["BA_Time"];
            $PatientPHN = $_POST["BA_PatientPHN"];
            $NurseID = $_POST["BA_NurseID"];
            $VaccineID = $_POST["BA_VaccineID"];
            $username = $_GET['pusername'];
            $BookerPHN = executePlainSQL(
                "SELECT PersonalHealthNumber FROM PatientAccount
                where Username = '$username'"
            );
            executePlainSQL(
                "INSERT INTO VaccinationAppointment (AppointmentID, ClinicID, Time, BookerPHN, PatientPHN, NurseID, VaccineID)
                VALUES ('$AppointmentID', '$ClinicID', TIMESTAMP '$DateAndTime', '$BookerPHN', '$PatientPHN', '$NurseID', '$VaccineID')"
            );
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
                else if (array_key_exists('printBookingInfo', $_POST)) {
                    printBookingInfo();
                }
                else if (array_key_exists('bookAppointment', $_POST)) {
                    bookAppointment();
                }
                else if (array_key_exists('cancelAppointment', $_POST)) {
                    cancelAppointment();
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