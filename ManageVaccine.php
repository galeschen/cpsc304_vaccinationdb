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
       $check = 0;
       
        function initialization(){
            // get manager ID from last page
            global $mID; 
            if($_GET){
                $mID = $_GET['mID'];       
            }else{
              echo "Url has no user";
            }

            // GET VACCINE NUMBER
            if (connectToDB()) {
                                         
                $countResult = executePlainSQL("SELECT COUNT(*) FROM Vaccine");
                $count = OCI_Fetch_Array($countResult, OCI_BOTH);
                echo "<br /> <h4> &nbsp&nbsp&nbsp" . $count[0] . " vaccines are found! <h4> <br />";

                disconnectFromDB();                
            }                         
        }
     
        // GET VACCINE INFO
        function showVaccineInfo() {
            global $db_conn;
            if (connectToDB()) {
                
                $result = executePlainSQL("SELECT * FROM Vaccine");
                echo "<table align='center'>";
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
            OCICommit($db_conn);
        }

        // GET VACCINE INFO
        function showIngredientInfo() {
            global $db_conn;
            if (connectToDB()) {
                // find the ingredients which are contained in all vaccines
                $IngreDResult = executePlainSQL("SELECT i.IName 
                From Ingredient i
                where not exists
                (select * from Vaccine v
                where not exists
                (select c.IngredientName
                from contains c
                where c.IngredientName=i.IName
                AND c.VaccineID = v.ID
                ))");
                echo "<table align='center'>";
                echo "<tr><th>Ingredient Name</th></tr>";
                // IngreD means ingredient division query
                while ($IngreDInfo = OCI_Fetch_Array($IngreDResult, OCI_BOTH)) {
                   
                    echo "<tr><td>" . $IngreDInfo[0] . "</td></tr>";
                }
                echo "</table>";
                               


                disconnectFromDB();                
            }         
            OCICommit($db_conn);
        }

        initialization();
        ob_start();
        
        if (isset($_POST['check']) && $_POST['check'] == 'View') {
            $check=1;
            ob_end_clean();
            ob_start();
            showIngredientInfo();
        } else if (!isset($_POST['check'])){
            $check=0;
            ob_end_clean();
            ob_start();
            showVaccineInfo();
        }        
        
        if (isset($_POST['back'])) {
            header("Location: ManagerHome.php?mID=".$mID);
            exit();
        }
		?>
        <br />
    
        <form method="POST" id='check'> 

        <input type="checkbox" value="View" name="check" onchange="this.form.submit()" <?php echo ($check==1 ? 'checked' : '');?>>
        <label id= 'labelcheck'for="check"> View ingredients which are in all vaccines</label><br>
        </form>

        <br />
    <br />
        <form method="POST" id='back' class='center'>

        <input type="submit" value="Back" name="back"></p> 
        </form>

        

    </body>
</html>