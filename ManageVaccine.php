<html>
    <head>
    <link rel="stylesheet" href = "./css/Manager.css">
        <title>CPSC 304 PHP/Manager Home</title>
    </head>
    <body>
    <br />
    <br />       
    <h2>Vaccine</h2>
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
           
            if (connectToDB()) {
                // Give vaccine info
                $result = executePlainSQL("SELECT * FROM Vaccine");
                echo "<table>";
                echo "<tr><th>Vaccine Name</th><th>ID</th><th>Is For</th><th>Cost</th><th>Availability</th><th>Ingredients</th></tr>";
                while ($VaccineInfo = OCI_Fetch_Array($result, OCI_BOTH)) {
                    // query the ingredients
                    $ingreResult = executePlainSQL("SELECT IngredientName FROM Contains where VaccineID = '$VaccineInfo[0]'");
                    // ingredient list
                    $ingredient = "";
                    while ($ingreInfo = OCI_Fetch_Array($ingreResult, OCI_BOTH)) {
                         $ingredient .= $ingreInfo[0] . "<br />";
                    }
                    echo "<tr><td>" . $VaccineInfo[1] . "</td><td> "
                    . $VaccineInfo[0] . "</td><td> "
                    . $VaccineInfo[2] . "</td><td> "
                    . $VaccineInfo[3] . "</td><td> "
                    . $VaccineInfo[4] . "</td><td>"
                    . $ingredient . "</td>";
                }
                echo "</table>";
                               


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
        if (isset($_POST['back'])) {
            header("Location: ManagerHome.php?mID=".$mID);
            exit();
        }
		?>
	<br />
    <br />
    <br />
        <form method="POST">

        <input type="submit" value="Back" name="back"></p> 
        </form>

    </body>
</html>