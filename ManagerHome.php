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
        
        $mID = NULL;       

        function initialization(){
            // get manager ID from last page
            global $mID;
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


                    echo "<table align='center'>";
                    echo "<tr><th>Clinic ID</th><th>Address</th><th>City</th><th>Postal Code</th><th>Nurse</th></tr>";
                  
                    $nurseResult = executePlainSQL("SELECT NName FROM Nurse ,WorksAt
                    where Nurse.ID = WorksAt.NurseID AND '$clinicInfo[0]' = WorksAt.ClinicID");
                    while ($nurseInfo = OCI_Fetch_Array($nurseResult, OCI_BOTH)) {
                         $nurses .= $nurseInfo[0] . "<br />";
                    }
                    echo "<tr><td>" . $clinicInfo[0] . "</td><td> "
                    . $clinicInfo[1] . "</td><td> "
                    . $clinicInfo[4] . "</td><td> "
                    . $clinicInfo[2] . "</td><td> "
                    . $nurses . "</td>";                
                    echo "</table>";  

                    }


                disconnectFromDB();                
            }            
        }

        initialization();
        if (isset($_POST['ManagerVaccine'])) {
            header("Location: ManageVaccine.php?mID=".$mID);
            exit();
        } else if (isset($_POST['ManagerNurse'])) {
            header("Location: ManageNurse.php?mID=".$mID);
            exit();
        }
        
		?>
	<br />

     <form method="POST" class='center'>

            <input type="submit" value="Manage Vaccine" name="ManagerVaccine"></p>
            <input type="submit" value="Manage Nurse" name="ManagerNurse"></p> 
    </form>
    
    <!-- Sign out -->
    <form method="POST" action="ManagerLogin.php" class='center'> 

    <input type="submit" value="Sign out" name="signout"></p>
    </form>

    </body>
</html>