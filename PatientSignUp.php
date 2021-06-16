<!DOCTYPE html>
<html>
    <head>
        <link rel = "stylesheet" href = "./css/Login.css">
        <title>CPSC 304 PHP/Patient Register</title>
    </head>
    <body>
    <br />
    <br />
        <h2>Register</h2>

        <hr />
        <br />
        <br />
        <br />
        <br />

        <!-- SignUp block -->
        <form method="POST" > 
            Personal Health Number: <input type="text" name="phn"> <br /><br />
            Name: <input type="text" name="name"> <br /><br />
            Sex:
        <input type="radio" name="sex"
        <?php if (isset($sex) && $sex=="male") echo "checked";?>
        value="male"> Male
        <input type="radio" name="sex"
        <?php if (isset($sex) && $sex=="female") echo "checked";?>
        value="female"> Female <br /><br /> 
            Address: <input type="text" name="address"> <br /><br />
            Postal Code:  <input type="text" name="postalcode"> <br /><br />
            Date of Birth: <input type="date" id = "birthday" name = "birthday"> <br /> <br /> 
            <hr />
            Username: <input type="text" name="username"> <br /><br />
            Password: <input type="text" name="password"> <br /><br />
            Confirm Password: <input type="text" name="cpassword"> <br /><br />

            <input type="submit" name="registerComplete" value = "Register">
        </form>
        <br />

        <?php
        include 'oracle_connection.php';
        $db_conn;
        
        function handleRegisterRequest() {
            global $db_conn;
            if (connectToDB()) {
                $login = true;
                $phn =  $_POST['phn'];
                $name = $_POST['name'];
                if ($_POST['sex'] == 'male'){
                    $sex = 'M';
                }else if ($_POST['sex'] == 'female') {
                    $sex = 'F';
                } else {
                    $login = false;
                    echo "<br><strong>Please select your sex!</strong><br />";
                }
                $address= $_POST['address'];
                $postal = $_POST['postalcode'];
                $birthday = $_POST['birthday'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $cpassword = $_POST['cpassword'];

                $time=strtotime($birthday);
                $year=date("Y",$time);

                if (strlen($phn) != 7 || is_int($phn)) {
                    $login = false;
                    echo "<strong>Incorrect format! Personal Health Number has seven digits.</strong><br />";
                }
                if ($name == NULL) {
                    $login = false;
                    echo "<strong>Please enter your Name!</strong><br />";
                }
                if ($address == NULL) {
                    $login = false;
                    echo "<strong>Please enter your address!</strong><br />";
                } 
                if (strlen($postal) != 6) {
                    $login = false;
                    echo "<strong>Incorrect postal code format!</strong><br />";
                }
                if (date("Y")< $year || $birthday == NULL) {
                    $login = false;
                    echo "<strong>Incorrect year selection!</strong><br />";
                }
                if ($username == NULL) {
                    $login = false;
                    echo "<strong>Please enter your username! </strong><br />";
                }
                if ($password == NULL || $cpassword == NULL) {
                    $login = false;
                    echo "<strong>Please enter your password! </strong><br />";
                }
                if ($password != $cpassword) {
                    $login = false;
                    echo "<strong>Confirm password doesn't match! </strong><br />";
                } 

                if ($login) {
                    executePlainSQL("INSERT INTO Patient VALUES ($phn,'$name','$sex','$address','$postal',DATE '$birthday')");
                    if (date("Y") - 19 > $year) {
                        executePlainSQL("INSERT INTO Adult VALUES ($phn)");
                    } else {
                        executePlainSQL("INSERT INTO Minor VALUES ($phn)");
                    }
                    executePlainSQL("INSERT INTO PatientAccount VALUES ('$username','$password',$phn)");
                    echo "success";
                    disconnectFromDB();  
                    OCICommit($db_conn);
                    header("Location: PatientSignUpSuccess.php");
                    exit();
                }
                disconnectFromDB();  
            }
            OCICommit($db_conn);
        }

    

        if (isset($_POST['registerComplete'])) {
            handleRegisterRequest();
        }
		?>
	</body>
</html>

