<?php
/*
Connection to your oracle database:
    * Include "include 'oracle_connection.php';" in other files
    * Change your ora_user to "ora_<cwl>", password to "a<student number>", and dbhost to "dbhost.students.cs.ubc.ca:1522/stu"
    * Not need to chmod 755 for this file
*/

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = NULL; // edit the login credentials in connectToDB()
$show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

// DB connection
function connectToDB() {
    global $db_conn;
    $ora_user = "ora_wangkj20";
    $password = "a15679400";
    $dbhost = "dbhost.students.cs.ubc.ca:1522/stu";
    $db_conn = OCILogon($ora_user, $password, $dbhost);

    if ($db_conn) {
        debugAlertMessage("Database is Connected");
        return true;
    } else {
        debugAlertMessage("Cannot connect to Database");
        $e = OCI_Error(); // For OCILogon errors pass no handle
        echo htmlentities($e['message']);
        return false;
    }
}

function debugAlertMessage($message) {
    global $show_debug_alert_messages;

    if ($show_debug_alert_messages) {
        echo "<script type='text/javascript'>alert('" . $message . "');</script>";
    }
}

// execute SQL
function executePlainSQL($cmdstr) { 
    global $db_conn, $success;

    $statement = OCIParse($db_conn, $cmdstr); 
    //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
        echo htmlentities($e['message']);
        $success = False;
    }

    $r = OCIExecute($statement, OCI_DEFAULT);
    if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
        echo htmlentities($e['message']);
        $success = False;
    }

    return $statement;
}

function disconnectFromDB() {
    global $db_conn;

    debugAlertMessage("Disconnect from Database");
    OCILogoff($db_conn);
}

?>