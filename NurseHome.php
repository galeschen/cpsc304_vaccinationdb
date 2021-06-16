<html>
    <head>
    <link rel="stylesheet" href = "./css/Nurse.css">
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

				// GET NURSE NAME
				$result = executePlainSQL("SELECT NName FROM Nurse WHERE ID = '$nID'");
                $nameResult = OCI_Fetch_Array($result, OCI_BOTH);
                $name = $nameResult[0];

				// WELCOME STATEMENT
                echo "<h3>Welcome " . $name . "!</h3>";

                // UPCOMING APPOINTMENTS
               echo "<h4>  Here are your upcoming appointments:</h4>";
				$result = executePlainSQL("SELECT Vaccine.VName AS Vaccine,
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
                    AND V.VaccineID = Vaccine.ID 
                    ORDER BY V.Time asc");

                    // find whether has appointment or not
                    $appointmentInfo = OCI_Fetch_Array($result, OCI_BOTH);
                    if ($appointmentInfo[0] == NULL) {
                        echo "<h5>You have no upcoming appointments!</h5>";
                    }
                    
                    $result = executePlainSQL("SELECT Vaccine.VName AS Vaccine,
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
                    AND V.VaccineID = Vaccine.ID 
                    ORDER BY V.Time asc");                    

                    echo "<table align='center'>";
                    echo "<tr>
                        <th>Vaccine</th>
                        <th>Patient</th>
                        <th>Clinic</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Date & Time</th>
                    </tr>";
                    
                    
                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        
                        echo "<tr>
                            <td>" . $row[0] . "</td>
                            <td>" . $row[1] . "</td>
                            <td>" . $row[2] . "</td>
                            <td>" . $row[3] . "</td>
                            <td>" . $row[4] . "</td>
                            <td>" .  $row[5] . "</td>
                        </tr>"; //or just use "echo $row[0]"
                    }
                    echo "</table>";
                disconnectFromDB();                
            }            
        }

        initialization();
		?>
        <br />
        <br />
        
        <!-- Sign out -->
            <form method="POST" action="NurseLogin.php" class='center'> 

        <input type="submit" value="Sign out" name="signout"></p>
        </form>
	</body>
</html>