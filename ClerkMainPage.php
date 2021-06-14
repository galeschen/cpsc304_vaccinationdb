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
        echo "TEST: WORKING WOOOOO<br>";
        global $db_conn;
        $sql = "SELECT * FROM ClericalStaff;";
        $result = $db_conn->query($sql);
        echo "TEST: WORKING WOOOOO<br>";
        while ($row = $result->fetch_assoc()) {
            echo "ID: ".$row["ID"]." Password: ".$row["Password"]." Name: ".$row["CName"]."<br>";
        }
		?>

	</body>
</html>

