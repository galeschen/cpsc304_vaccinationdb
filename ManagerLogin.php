<html>
    <head>
         <link rel="stylesheet" href = "./css/Login.css">
        <title>CPSC 304 PHP/Manager Login</title>
    </head>

    <body>
    <br />
    <br />
        <h2>Log in</h2>        
        <hr />
        <br />
        <h3>Manager</h3>
        <br />
        <br />
        <br />

        <!-- Login block -->
        <form method="POST" class='center'> 
            <input type="hidden" id="loginRequest" name="loginRequest">
            
            Manager ID: <input type="text" name="Manager_ID"> <br /><br />
            Password: <input type="password" name="password"> <br /><br />

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
            $Manager_ID =  $_POST['Manager_ID'];
            $password = $_POST['password'];
            $result = executePlainSQL("SELECT mPassword FROM Manager
                                                where ID = '$Manager_ID'");
            $correctpassword = OCI_Fetch_Array($result, OCI_BOTH);
            if($correctpassword[0] == NULL) {
                echo "Manager ID cannot be found";
            } else if ($password == $correctpassword[0]) {
                disconnectFromDB();
                header("Location: ManagerHome.php?mID=".$Manager_ID);
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