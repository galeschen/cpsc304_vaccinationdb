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
				$result = executePlainSQL("SELECT Patient.PersonalHealthNumber
				FROM Patient, PatientAccount
				WHERE PatientAccount.Username = '$pusername'");
				$phnResult = OCI_Fetch_Array($result, OCI_BOTH);
				$phn = $phnResult[0];

				// GET PATIENT NAME: join patient and patientaccount
				$result = executePlainSQL("SELECT Patient.PName
				FROM Patient, PatientAccount
				WHERE PatientAccount.Username = '$pusername'
				AND PatientAccount.PersonalHealthNumber = Patient.PersonalHealthNumber");
                $nameResult = OCI_Fetch_Array($result, OCI_BOTH);
                $name = $nameResult[0];

				// WELCOME STATEMENT
                echo "<h2>Welcome " . $name . "!</h2>";

                // UPCOMING APPOINTMENTS
                echo "<h4> &nbsp &nbsp &nbsp Your upcoming appointments:</h4> <br /> <br />";
				// $result = executePlainSQL("SELECT C.ClinicName, C.StreetAddress, A.City, V.Time
				// 	FROM VaccinationAppointment V, Clinic C, ClinicAddress, A
				// 	WHERE V.PatientPHN = ");

				// BUTTON TO BOOK A NEW APPOINTMENT

				// BUTTON TO CANCEL AN APPOINTMENT.... if i have time
                }


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