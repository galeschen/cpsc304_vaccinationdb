<html>
    <head>
         <link rel="stylesheet" href = "./css/Login.css">
        <title>CPSC 304 PHP/Nurse Login</title>
    </head>

    <body>
    <br />
    <br />
        <h2>Log in</h2>        
        <hr />
        <br />
        <h3>Nurse</h3>
        <br />
        <br />
        <br />

        <!-- Login block -->
        <form method="POST" action="NurseLogin.php"> <!--refresh page when submitted-->
            <input type="hidden" id="loginRequest" name="loginRequest">
            
            Nurse ID: <input type="text" name="Nurse_ID"> <br /><br />
            Password: <input type="text" name="password"> <br /><br />

            <input type="submit" value="login" name="login"></p>
        </form>

        <br />

        <?php
        include 'oracle_connection.php';
        
        function handleloginRequest() {
            global $db_conn;
            $Nurse_ID =  $_POST['Nurse_ID'];
            $password = $_POST['password'];
            $result = executePlainSQL("SELECT NPassword FROM Nurse
                                                where ID = '$Nurse_ID'");
            $correctpassword = OCI_Fetch_Array($result, OCI_BOTH);
            if($correctpassword[0] == NULL) {
                echo "Nurse ID cannot be found";
            } else if ($password == $correctpassword[0]) {
                header("Location: NurseHome.php?nID=".$Nurse_ID);
                exit();
            } else {
                echo "Incorrect password";
            }
            OCICommit($db_conn);
        }

    
        // HANDLE ALL POST ROUTES
	    function handlePostRequest() {
            if (connectToDB()) {
                if (array_key_exists('loginRequest', $_POST)) {
                    handleloginRequest();

                disconnectFromDB();
            }
            }
        }

        if (isset($_POST['login'])) {
            handlePostRequest();
        }
		?>
	</body>
</html>