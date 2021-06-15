<html>
    <head>
        <title>CPSC 304 PHP/Clerk Main Page</title>
    </head>

    <style>
    h2 {text-align: center;}
    form {text-align: center;}
    </style>
    <body>
    <br />
    <br />
        <h2>Clerk</h2>

        <hr />
        <br />
        <br />
        <br />
        <br />

        <form method="POST" action="Vaccination.php">
            <input type="submit" value="Exit" name="Exit"></p>
        </form>

        <form method="POST" action="ClerkHome.php">
            <input type="submit" value="printData" name="printData"></p>
        </form>

        <br />
        <?php
        include 'oracle_connection.php';
        function printData() {
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM ClericalStaff");
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "ID: ".$row["ID"]." Password: ".$row["Password"]." Name: ".$row["CName"]."<br>";
            }
            OCICommit($db_conn);
        }

        // HANDLE ALL POST ROUTES
	    function handlePostRequest() {
            if (connectToDB()) {
                if (array_key_exists('printData', $_POST)) {
                    printData();

                disconnectFromDB();
            }
            }
        }

        if (isset($_POST['printData'])) {
            handlePostRequest();
        }
        
        
		?>

	</body>
</html>

