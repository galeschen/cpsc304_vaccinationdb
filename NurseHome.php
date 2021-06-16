<html>
    <head>
    <link rel="stylesheet" href = "./css/Patient.css">
        <title>CPSC 304 PHP/Nurse Home</title>
    </head>
    <body>
    <br />
    <br />       

        <?php
        include 'oracle_connection.php';
       
        function initialization(){
			// get patient username from last page
            if($_GET){
                $nID = $_GET['nID'];       
            }else{
              echo "Url has no user";
            }
            if (connectToDB()) {
				// echo "debug - you made it.";

				// GET NURSE NAME
				$result = executePlainSQL("SELECT NName FROM Nurse WHERE ID = '$nID'");
                $nameResult = OCI_Fetch_Array($result, OCI_BOTH);
                $name = $nameResult[0];

				// WELCOME STATEMENT
                echo "<h3>Welcome " . $name . "!</h3>";

                // UPCOMING APPOINTMENTS
                echo "<h4> &nbsp &nbsp &nbsp Here are your upcoming appointments:</h4>";
				$result = executePlainSQL(
                    "SELECT Vaccine.VName AS Vaccine,
                    P.PName AS Patient,
                    C.ClinicName AS Clinic, 
                    C.StreetAddress AS ClinicAddress, 
                    A.City AS ClinicCity,
                    V.Time AS AppointmentTime
                    FROM VaccinationAppointment V, Clinic C, ClinicAddress A, Patient P, Vaccine
                    WHERE V.NurseID = '$nID'
                    AND P.PersonalHealthNumber = V.PatientPHN
                    AND C.ClinicID = V.ClinicID
                    AND A.PostalCode = C.PostalCode
                    AND V.VaccineID = Vaccine.ID"
                );
                    // 3234842

                    // TODO: TRYING TO MAKE IT SO THAT THE "NO APPOINTMENTS" MESSAGE ONLY SHOWS UP IF THE NURSE HAS NO APPOINTMENTS
                    if ($result[0] == NULL) {
                        echo "<h5>You have no upcoming appointments!</h5>";
                    }
                    // this is working.
                    while ($appointmentInfo = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo "<h5>Vaccine: $appointmentInfo[0]  <br />
                        Patient:  $appointmentInfo[1] <br />
                        Clinic: $appointmentInfo[1]  <br />
                        Address: $appointmentInfo[2], $appointmentInfo[3] <br />
                        Time: $appointmentInfo[4]</h5>";
                    }

                    $result = executePlainSQL(
                        "SELECT Vaccine.VName AS Vaccine,
                        P.PName AS Patient,
                        C.ClinicName AS Clinic, 
                        C.StreetAddress AS ClinicAddress, 
                        A.City AS ClinicCity,
                        V.Time AS AppointmentTime
                        FROM VaccinationAppointment V, Clinic C, ClinicAddress A, Patient P, Vaccine
                        WHERE V.NurseID = '$nID'
                        AND P.PersonalHealthNumber = V.PatientPHN
                        AND C.ClinicID = V.ClinicID
                        AND A.PostalCode = C.PostalCode
                        AND V.VaccineID = Vaccine.ID"
                    );

                    // TODO: TRYING TO MAKE IT SO THAT ALL APPOINTMENTS SHOW UP IN TABULAR FORMAT
                    echo "<table>";
                    echo "<tr>
                        <th>Vaccine</th>
                        <th>Clinic</th>
                        <th>Patient</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Time</th>
                    </tr>";
                    
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo "<tr>
                            <td>" . $row[0] . "</td>
                            <td>" . $row[2] . "</td>
                            <td>" . $row[1] . "</td>
                            <td>" . $row[3] . "</td>
                            <td>" . $row[4] . "</td>
                            <td>" .  $row[5] . "</td>
                        </tr>"; //or just use "echo $row[0]"
                    }
                    echo "</table>";
                disconnectFromDB();                
            }            
        }
     

        function handleloginRequest() {
            global $db_conn;
            
            OCICommit($db_conn);
        }

        initialization();
		?>
	</body>
</html>