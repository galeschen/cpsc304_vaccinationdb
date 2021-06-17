<html>
    <head>
        <link rel="stylesheet" href = "./css/Patient.css">
        <title>CPSC 304 PHP/Patient Home</title>
    </head>
    <body>
    <br />
    <br />       

    <h3>Reset Your Account Password</h3>
    <form method="POST" class ='center'> 
        
        New Password: <input type="text" name="RP_ppassword"> <br /><br />
        <input type="submit" value="Reset Password" name="updatePatientAccountPassword"></p>
    </form>   

    <h3>Update Address</h3>
    <form method="POST" class ='center'> 
        
        Street Address: <input type="text" name="UA_StreetAddress"> <br /><br />
        Postal Code: <input type="text" name="UA_PostalCode"> <br /><br />
        City: <input type="text" name="UA_City"> <br /><br />
        <input type="submit" value="Update Address" name="updatePatientAccountAddress"></p>
    </form>

    <form method="POST" class ='center'> 
        <input type="submit" value="Show Appointment Booking Info" name="printBookingInfo"></p>
    </form>

    <h3>Book your next appointment</h3>
    <form method="POST" class ='center'> 
        
        Appointment ID: <input type="text" placeholder="5 Digits Max" name="BA_AppointmentID"> <br /><br />
        Clinic ID: <input type="text" placeholder="Pick from Available" name="BA_ClinicID"> <br /><br />
        Date: <input type="date" name="BA_Date"> <br /><br />
        Time: <input type="time" name="BA_Time"> <br /><br />
        Your PHN: <input type="text" name="BA_PatientPHN"> <br /><br />
        Nurse ID: <input type="text" placeholder="Pick from Available" name="BA_NurseID"> <br /><br />
        Vaccine ID: <input type="text" placeholder="Pick from Available" name="BA_VaccineID"> <br /><br />
        <input type="submit" value="Book Appointment" name="bookAppointment"></p>
    </form>

    <h3>Cancel Appointment</h3>
    <form method="POST" class ='center'> 
        
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

                echo "<h3>Here is your information:</h3>";
                echo "<table align='center'>";
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
                echo "<h3>These are your upcoming vaccination appointments:</h3>";
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

                    // we also had that information in table form:
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
                    // }
                    // echo "</table>";
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

        function updatePatientAccountPassword() {
            global $db_conn;
            $PatientUsername = $_GET['pusername'];
            $NewPassword = $_POST["RP_ppassword"];
            executePlainSQL("UPDATE PatientAccount SET ppassword = '$NewPassword' WHERE Username = '$PatientUsername'");
            echo "Password for '$PatientUsername' updated to '$NewPassword'<br>";
            OCICommit($db_conn);
        }

        function updatePatientAccountAddress() {
            global $db_conn;
            $PatientUsername = $_GET['pusername'];
            
            $NewStreetAddress = $_POST['UA_StreetAddress'];
            $NewPostalCode = $_POST['UA_PostalCode'];
            $NewCity = $_POST['UA_City'];

            $countresult = executePlainSQL("SELECT COUNT(*) FROM PatientAddress WHERE PostalCode = '$NewPostalCode'");
            $count = OCI_Fetch_Array($countresult, OCI_BOTH);
            if ($count[0] == 0) {
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
            echo "<table align='center'><caption>Clinics</caption>";
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
            echo "<br />";
            $result = executePlainSQL(
                "SELECT * 
                FROM Nurse"
            );
            echo "<table align='center'><caption>Nurses</caption>";
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
            echo "<br />";
            $result = executePlainSQL(
                "SELECT * 
                FROM Vaccine"
            );
            echo "<table align='center'><caption>Vaccines</caption>";
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

        function bookAppointment() {
            // echo "made it to book appt.";
            global $db_conn;
            $AppointmentID = $_POST["BA_AppointmentID"];
            $ClinicID = $_POST["BA_ClinicID"];
            $date = $_POST["BA_Date"];
            $time = $_POST["BA_Time"];
            $PatientPHN = $_POST["BA_PatientPHN"];
            $NurseID = $_POST["BA_NurseID"];
            $VaccineID = $_POST["BA_VaccineID"];
            $username = $_GET['pusername'];
            $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
            executePlainSQL(
                "INSERT INTO VaccinationAppointment
                VALUES ('$AppointmentID', '$ClinicID', timestamp '$combinedDT', $PatientPHN, $PatientPHN, '$NurseID', '$VaccineID')"
            );
            echo "Appointment booked!";
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

        initialization();
        handlePostRequest();
		?>

    <form method="POST" action="PatientLogin.php" class='center'> <!--refresh page when submitted-->
    <input type="submit" value="Logout" name="logout"></p>
    </form>
	</body>
</html>