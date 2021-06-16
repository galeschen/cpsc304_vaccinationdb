<html>
    <head>
    <link rel="stylesheet" href = "./css/Patient.css">
        <title>CPSC 304 PHP/Patient Home</title>
    </head>
    <body>
    <br />
    <br />       

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
                echo "<h3>Welcome " . $name . "!</h3>";

                // debugging
                // echo "<h3>(Debug) Welcome " . $phn . "!</h3>";

                // UPCOMING APPOINTMENTS
                echo "<h4> &nbsp &nbsp &nbsp Here is your next vaccination appointment:</h4> <br /> <br />";
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
                    // 3234842
                    if ($appointmentInfo[0] = NULL) {
                        echo "<h5>You have no upcoming appointments!</h5>";
                    }
                    while ($appointmentInfo = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo "<h5>Vaccine: $appointmentInfo[0]  <br />
                        Clinic: $appointmentInfo[1]  <br />
                        Address: $appointmentInfo[2], $appointmentInfo[3] <br />
                        Time: $appointmentInfo[4]</h5>";

                        // echo "<h5> <b> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp"
                        // . $appointmentInfo[0] ."  </b></h5>";
                        // echo "<h6>  " . $appointmentInfo[1] . "&nbsp &nbsp &nbsp &nbsp"
                        // . $appointmentInfo[1] . "&nbsp &nbsp &nbsp &nbsp"
                        // . $appointmentInfo[2] . "&nbsp &nbsp &nbsp &nbsp"
                        // . $appointmentInfo[3] . "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</h6> <br />";
                        // . $appointmentInfo[] . "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</h6> <br />";
                    }

				// BUTTON TO BOOK A NEW APPOINTMENT

				// BUTTON TO CANCEL AN APPOINTMENT.... if i have time

                disconnectFromDB();                
            }            
        }
     

        function handleloginRequest() {
            global $db_conn;
            
            OCICommit($db_conn);
        }

    
        // HANDLE ALL POST ROUTES
	    // function handlePostRequest() {
        //     if (connectToDB()) {
        //         if (array_key_exists('loginRequest', $_POST)) {
        //             handleloginRequest();

        //         disconnectFromDB();
        //     }
        //     }
        // }

        // if (isset($_POST['login'])) {
        //     handlePostRequest();
        // }

        initialization();
		?>
	</body>
</html>