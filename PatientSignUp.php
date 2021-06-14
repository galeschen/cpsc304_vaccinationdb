<html>
    <head>
        <title>CPSC 304 PHP/Patient Sign Up</title>
    </head>

    <style>
    h2 {text-align: center;}
    form {text-align: center;}
    </style>
    <body>
    <br />
    <br />
        <h2>Patient Sign Up</h2>

        <hr />
        <br />
        <br />
        <br />
        <br />

        <!-- Sign up block-->
        <form method="POST" action="PatientSignUpSuccess.php">
            <input type="hidden" id="signUpRequest" name="signUpRequest">
            
            Personal Health Number: <input type="text" name="personal health number"> <br /><br />
            New Username: <input type="text" name="username"> <br /><br />
            New Password: <input type="text" name="password"> <br /><br />

            <input type="submit" value="Sign Up" name="signUp"></p>
        </form>

        <?php
        include 'oracle_connection.php';
        
        function handleSignUpRequest() {
            global $db_conn;
            $phn = $_POST['personal health number'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $result = executePlainSQL("INSERT INTO PatientAccount VALUES ($username, $password, $phn)");
            $correctinsert = OCI_Fetch_Array($result, OCI_BOTH);
            // TODO:
            // if PHN already exists in PatientAccount, echo "Personal Health Number already associated with an account."
            // if username already exists in PatientAccount, echo "Username is already in use."
            // $correctinsert = OCI_Fetch_Array($result, OCI_BOTH);
            // if($correctinsert[0] == NULL) {
            //     echo "Username cannot be found";
            // } else if ($password == $correctinsert[0]) {
            //     echo "correct";
            // } else {
            //     echo "incorrect password";
            // }
            OCICommit($db_conn);
        }

    
        // HANDLE ALL POST ROUTES
	    function handlePostRequest() {
            if (connectToDB()) {
                if (array_key_exists('signUpRequest', $_POST)) {
                    handleSignUpRequest();
                disconnectFromDB();
            }
            }
        }

        if (isset($_POST['signUp'])) {
            handlePostRequest();
        }
		?>
	</body>
</html>