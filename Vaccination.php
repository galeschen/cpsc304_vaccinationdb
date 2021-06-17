<html>
    <head>
    <link rel = "stylesheet" href = "./css/Main.css">
        <title>CPSC 304 PHP/VaccinationRegistration</title>
    </head>
    <body>
        <h2>Welcome</h2>

        <br />
        <br />
        <br />
        <br />

        <h3>Are you?</h3>
        <br />
        <br />
        <form method="POST" action="PatientLogin.php"> <!--refresh page when submitted-->

            <input type="submit" value="Patient" name="Plogin"></p>
        </form>

        <form method="POST" action="NurseLogin.php"> <!--refresh page when submitted-->

            <input type="submit" value="Nurse" name="Nlogin"></p>
        </form>

        <form method="POST" action="ManagerLogin.php"> <!--refresh page when submitted-->

            <input type="submit" value="Manager" name="Mlogin"></p>
        </form>

        <form method="POST" action="ClerkLogin.php"> <!--refresh page when submitted-->

            <input type="submit" value="Clerk" name="Clogin"></p>
        </form>

	</body>
</html>

