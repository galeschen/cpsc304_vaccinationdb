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
        <br />

        <?php
        include 'oracle_connection.php';
        
        

    
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

