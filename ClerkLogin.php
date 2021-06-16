<html>
    <head>
    <link rel="stylesheet" href = "./css/Login.css">
        <title>CPSC 304 PHP/Clerk Login</title>
    </head>

    <style>
    h2 {text-align: center;}
    form {text-align: center;}
    </style>
    <body>
    <br />
    <br />
        <h2>Log in</h2>

        <hr />
        <br />
        <br />
        <br />
        <br />

        <!-- Login block -->
        <form method="POST" action="ClerkLogin.php"> <!--refresh page when submitted-->
            <input type="hidden" id="loginRequest" name="loginRequest">
            
            Clerk ID: <input type="text" name="Clerk_ID"> <br /><br />
            Password: <input type="text" name="password"> <br /><br />

            <input type="submit" value="login" name="login"></p>
        </form>

        <!-- Back to main -->
        <form method="POST" action="Vaccination.php" class='center'> 

            <input type="submit" value="Back" name="back"></p>
        </form>

        <br />

        <?php
        include 'oracle_connection.php';
        
        function handleloginRequest() {
            global $db_conn;
            $Clerk_ID =  $_POST['Clerk_ID'];
            $password = $_POST['password'];
            $result = executePlainSQL("SELECT Password FROM ClericalStaff
                                                where ID = '$Clerk_ID'");
            $correctpassword = OCI_Fetch_Array($result, OCI_BOTH);
            if($correctpassword[0] == NULL) {
                echo "Clerk ID cannot be found";
            } else if ($password == $correctpassword[0]) {
                header("Location: ClerkHome.php");
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