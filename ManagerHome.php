<html>
    <head>
    <link rel="stylesheet" href = "./css/Manager.css">
        <title>CPSC 304 PHP/Manager Home</title>
    </head>
    <body>
    <br />
    <br />       

        <?php
        include 'oracle_connection.php';
        // get manager ID from last page
       

        function initialization(){
            if($_GET){
                $mID = $_GET['mID'];       
            }else{
              echo "Url has no user";
            }
            // get manager Name
            if (connectToDB()) {
                // WELCOME MESSAGE
                $result = executePlainSQL("SELECT MName FROM Manager
                        where ID = '$mID'");
                $nameResult = OCI_Fetch_Array($result, OCI_BOTH);
                $name = $nameResult[0];
                echo "<h2>Welcome " . $name . "!</h2>";

                // CLINIC INFO
                echo "<h4> &nbsp &nbsp &nbsp Your Clinic Info:</h4> <br /> <br />";
                $result = executePlainSQL("SELECT clinicID, StreetAddress, Clinic.PostalCode, ClinicName, City FROM Clinic, ClinicAddress
                        where ManagerID = '$mID' AND ClinicAddress.PostalCode = Clinic.PostalCode");
                while ($clinicInfo = OCI_Fetch_Array($result, OCI_BOTH)) {
                    echo "<h5> <b> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp"
                    . $clinicInfo[3] ."  </b></h5>";
                    echo "<h6>  " . $clinicInfo[0] . "&nbsp &nbsp &nbsp &nbsp"
                    . $clinicInfo[1] . "&nbsp &nbsp &nbsp &nbsp"
                    . $clinicInfo[4] . "&nbsp &nbsp &nbsp &nbsp"
                    . $clinicInfo[2] . "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</h6> <br />";
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