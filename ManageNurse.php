<html>
    <head>
    <link rel="stylesheet" href = "./css/Manager.css"> 
        <title>CPSC 304 PHP/Manager Home</title>
    </head>
    <body>
    <br />
    <br />       
    <h2>Nurses</h2>
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

            // Nurse info 
            if (connectToDB()) {
                $nurseResult = executePlainSQL("SELECT ID,NName FROM Nurse WHERE ID IN
                                                     (SELECT NurseID FROM WorksAt WHERE ClinicID IN
                                                     (SELECT ClinicID FROM Clinic WHERE ManagerID = '$mID'))");
                // nurses table
                echo "<table align='center'>";
                echo "<tr><th>Nurse ID</th><th>Nurse Name</th></tr>";
                while ($nurses = OCI_Fetch_Array($nurseResult, OCI_BOTH)) {
                   
                    echo "<tr><td>" . $nurses[0] . "</td><td>" . $nurses[1] . "</td></tr>";
                }
                echo "</table>";
                disconnectFromDB();                
            }       
            OCICommit($db_conn);                  
        }

        // Dismiss nurse
        function dismissNurse() {
            global $db_conn;
            global $mID;
            if (connectToDB()) {
                $dismissID = $_POST['dismisstext'];
                $nurseResult = executePlainSQL("SELECT ID from Nurse where ID='$dismissID'");
                $nurse = OCI_Fetch_Array($nurseResult, OCI_BOTH);
                if($nurse[0] != NULL){
                    executePlainSQL("DELETE FROM Nurse where ID='$dismissID'");  
                    echo "<h6 text_align='center>Nurse " . $dismissID . " are removed!</h6>";                    
                } else {
                    echo "<h6>Nurse ID not found!</h6>";
                }           


                disconnectFromDB();                
            }         
            OCICommit($db_conn);
        }

        initialization();
        
        
        if (isset($_POST['back'])) {
            header("Location: ManagerHome.php?mID=".$mID);
            exit();
        } else if (isset($_POST['dismiss'])) {
            dismissNurse();
            header("Location: ManageNurse.php?mID=".$mID);
            exit();
        }
		?>
    

        <br />
        <form method="POST" class='center'>

        <label id= 'dimissLabel'for="dismisstext"> Dismiss a nurse by ID        </label>
        <input type="text" value="" name="dismisstext" id='dismiss'>
        <input type="submit" value="Dismiss" name="dismiss"></p> 
        </form>

        <br />
        <form method="POST" class='center'>

        <input type="submit" value="Back" name="back"></p> 
        </form>

       

        

    </body>
</html>